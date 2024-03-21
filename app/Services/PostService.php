<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Services\Interfaces\PostServiceInterface;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostService extends BaseService implements PostServiceInterface
{
    protected $postRepository;
    protected $nestedset;
    protected $currentLanguage;

    public function __construct(
        PostRepository $postRepository,
    ) {
        $this->postRepository = $postRepository;
        $this->currentLanguage = $this->currentLanguage();

        $this->nestedset = new Nestedsetbie([
            'table' => 'posts',
            'foreignkey' => 'post_id',
            'language_id' => $this->currentLanguage
        ]);
    }
    function paginate()
    {
        $condition['keyword'] = addslashes(request('keyword'));
        $condition['publish'] = request('publish');
        $condition['where'] = [
            'tb2.language_id' => $this->currentLanguage
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
            'post_language as tb2' => ['tb2.post_id', '=', 'posts.id']
        ];
        $orderBy = [];

        //////////////////////////////////////////////////////////
        $posts = $this->postRepository->pagination(
            $select,
            $condition,
            request('perpage'),
            $orderBy,
            $join,
            ['post_catalogues']
        );
        // dd($posts);

        return $posts;
    }

    function create()
    {

        DB::beginTransaction();
        try {

            //   Lấy ra payload và format lai
            $payload = $this->formatPayload();
            // Lấy ra id người dùng hiện tại
            $payload['user_id'] = Auth::id();

            // Create post
            $post = $this->postRepository->create($payload);
            if ($post->id > 0) {
                // Format lai payload language
                $payloadPostLanguage = $this->formatPayloadLanguage($post->id);

                // Create pivot and sync
                $this->createPivotAndSync($post, $payloadPostLanguage);
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
            $payload = $this->formatPayload();

            // Update post
            $updatePost = $this->postRepository->update($id, $payload);

            if ($updatePost) {
                // Format lai payload language
                $payloadPostLanguage = $this->formatPayloadLanguage($id);
                // Xoá bản ghi cũa một pivot
                $post->languages()->detach([$payloadPostLanguage['language_id'], $id]);
                // Create pivot and sync
                $this->createPivotAndSync($post, $payloadPostLanguage);
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
        return array_unique(array_merge(
            request('catalogue'),
            [request('post_catalogue_id')],
        ));
    }

    private function formatPayload()
    {
        // Lấy ra payload từ form
        $payload = request()->only($this->payload());
        if (isset($payload['album']) && !empty($payload['album'])) {
            $payload['album'] = json_encode($payload['album']);
        }
        return $payload;
    }

    private function formatPayloadLanguage($postId)
    {
        $payloadPostLanguage = request()->only($this->payloadPostLanguage());
        //Đinh dạng slug
        $payloadPostLanguage['canonical'] = Str::slug($payloadPostLanguage['canonical']);

        // Lấy ra post_id 
        $payloadPostLanguage['post_id'] = $postId;
        // Lấy ra language_id mặc định
        $payloadPostLanguage['language_id'] = $this->currentLanguage;
        return $payloadPostLanguage;
    }

    private function createPivotAndSync($post, $payloadPostLanguage)
    {
        // Tạo ra pivot vào bảng post_language
        $this->postRepository->createPivot($post, $payloadPostLanguage, 'languages');

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

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    function updateStatus()
    {
        DB::beginTransaction();
        try {
            $payload[request('field')] = request('value') == 1 ? 0 : 1;
            $update =  $this->postRepository->update(request('modelId'), $payload);

            if (!$update) {
                DB::rollBack();
                return false;
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    public function updateStatusAll()
    {
        DB::beginTransaction();
        try {
            $payload[request('field')] = request('value');
            $update =  $this->postRepository->updateByWhereIn('id', request('id'), $payload);

            if (!$update) {
                DB::rollBack();
                return false;
            }
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

    private function payloadPostLanguage()
    {
        return ['name', 'canonical', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
    }
}
