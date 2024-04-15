<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\PostServiceInterface;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostService extends BaseService implements PostServiceInterface
{
    protected $postRepository;

    public function __construct(
        PostRepository $postRepository,
    ) {
        parent::__construct();
        $this->postRepository = $postRepository;
        $this->controllerName = 'PostController';
    }
    function paginate()
    {

        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
            'post_catalogue_id' => request('post_catalogue_id'),
            'where' => [
                'tb2.language_id' => ['=', session('currentLanguage')]
            ]
        ];

        $select = [
            'posts.id',
            'posts.publish',
            'posts.image',
            'posts.user_id',
            'posts.order',
            'tb2.name',
            'tb2.canonical',
        ];
        $join = [
            'post_language as tb2' => ['tb2.post_id', '=', 'posts.id'],
            'post_catalogue_post as tb3' => ['tb3.post_id', '=', 'posts.id'],
        ];
        $orderBy = [];

        //////////////////////////////////////////////////////////
        $posts = $this->postRepository->pagination(
            $select,
            $condition,
            request('perpage'),
            $orderBy,
            $join,
            ['post_catalogues'],
            $select,
            $this->whereRaw()

        );

        // dd($posts);
        return $posts;
    }

    private function whereRaw()
    {
        $rawConditions = [];
        $post_catalogue_id = request('post_catalogue_id');
        if ($post_catalogue_id > 0) {
            $rawConditions['whereRaw'] = [
                [
                    'tb3.post_catalogue_id IN (
                        SELECT id 
                        FROM post_catalogues
                        INNER JOIN post_catalogue_language as pcl ON pcl.post_catalogue_id = post_catalogues.id 
                        WHERE `left` >= (SELECT `left` FROM post_catalogues as pc WHERE pc.id = ?)
                        AND `right` <= (SELECT `right` FROM post_catalogues as pc WHERE pc.id = ?)
                        AND pcl.language_id = ?
                    )',
                    [$post_catalogue_id, $post_catalogue_id, session('currentLanguage')]
                ]
            ];
        }
        return $rawConditions;
    }

    function create()
    {

        DB::beginTransaction();
        try {

            //   Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatJson($payload, 'album');
            // Lấy ra id người dùng hiện tại
            $payload['user_id'] = Auth::id();

            // Create post
            $post = $this->postRepository->create($payload);
            if ($post->id > 0) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($post->id);
                // Create pivot and sync
                $this->createPivotAndSync($post, $payloadLanguage);

                // create router
                $this->createRouter($post);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }


    function update($id)
    {

        DB::beginTransaction();
        try {
            // Lấy ra dữ liệu của post hiện tại để xoá;
            $post = $this->postRepository->findById($id);

            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatJson($payload, 'album');
            // Update post
            $updatePost = $this->postRepository->update($id, $payload);

            if ($updatePost) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($id);
                // Xoá bản ghi cũa một pivot
                $post->languages()->detach([$payloadLanguage['language_id'], $id]);
                // Create pivot and sync
                $this->createPivotAndSync($post, $payloadLanguage);

                // update router
                $this->updateRouter($post);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }

    private function catalogue()
    {
        if (!empty(request('catalogue'))) {
            return array_unique(array_merge(
                request('catalogue'),
                [request('post_catalogue_id')],
            ));
        }
        return [request('post_catalogue_id')];
    }


    private function formatPayloadLanguage($postId)
    {
        $payloadLanguage = request()->only($this->payloadLanguage());
        //Đinh dạng slug
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);

        // Lấy ra post_id 
        $payloadLanguage['post_id'] = $postId;
        // Lấy ra language_id mặc định
        $payloadLanguage['language_id'] = session('currentLanguage');
        return $payloadLanguage;
    }

    private function createPivotAndSync($post, $payloadLanguage)
    {
        // Tạo ra pivot vào bảng post_language
        $this->postRepository->createPivot($post, $payloadLanguage, 'languages');

        // Lấy ra id catalogue
        $catalogue = $this->catalogue();
        // Đồng bộ hoá id catalogue với bảng post_catalogue_post
        $post->post_catalogues()->sync($catalogue);
    }



    function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $delete = $this->postRepository->delete($id);
            // Xoa router
            $this->deleteRouter($id);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }


    private function payload()
    {
        return ['post_catalogue_id', 'image', 'follow', 'publish', 'album'];
    }

    private function payloadLanguage()
    {
        return ['name', 'canonical', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
    }
}
