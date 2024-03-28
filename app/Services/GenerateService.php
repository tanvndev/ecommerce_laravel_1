<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\GenerateServiceInterface;
use App\Repositories\Interfaces\GenerateRepositoryInterface as GenerateRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;


class GenerateService implements GenerateServiceInterface
{
    protected $generateRepository;
    public function __construct(GenerateRepository $generateRepository)
    {
        $this->generateRepository = $generateRepository;
    }
    function paginate()
    {
        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
        ];
        $generates = $this->generateRepository->pagination(
            ['id', 'name', 'image', 'publish', 'canonical', 'user_id'],
            $condition,
            request('perpage'),

        );
        // dd($generates->links());
        return $generates;
    }


    public function create()
    {
        DB::beginTransaction();
        try {
            // $database = $this->makeDatabase();
            // $controller =  $this->makeController();
            //$model = $this->makeModel();
            // $repository = $this->makeRepository();
            // $service = $this->makeService();

            $provider = $this->makeProvider();

            // $this->makeRequest();
            // $this->makeView();
            // $this->makeRoute();
            // $this->makeRule();
            // $this->makeLang();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }

    private function makeProvider()
    {
    }

    private function makeService()
    {
        $name = request('name');
        $tableName = $this->convertModuleNameToTableName($name);
        $replace = [
            'ModuleTemplate' => ucfirst($name),
            'moduleTemplate' => lcfirst($name),
            'tableName' => $tableName . 's',
            'pivotTable' => $tableName . '_language',
            'foreignKey' => $tableName . '_id',
        ];

        return $this->initialzeServiceLayer($name, 'Service', 'Services', $replace);
    }

    private function makeRepository()
    {
        $name = request('name');
        $tableName = $this->convertModuleNameToTableName($name);
        $replace = [
            'ModuleTemplate' => ucfirst($name),
            'tableName' => $tableName . 's',
            'pivotTable' => $tableName . '_language',
            'foreignKey' => $tableName . '_id',
        ];

        return $this->initialzeServiceLayer($name, 'Repository', 'Repositories', $replace);
    }

    private function initialzeServiceLayer($name = '', $layerName = '', $forderName, $replace = [])
    {
        try {
            // Lấy ra đường dẫn template
            $templateLayerInterfacePath = base_path('app/Templates/Template' . ucfirst($layerName) . 'Interface.php');
            $templateLayerPath = base_path('app/Templates/Template' . ucfirst($layerName) . '.php');


            // Đọc nội dung của file
            $layerInterFaceContent = file_get_contents($templateLayerInterfacePath);
            $layerContent = file_get_contents($templateLayerPath);


            $layerInterFaceContent = $this->formatContent($layerInterFaceContent, $replace);
            $layerContent = $this->formatContent($layerContent, $replace);


            $layerInterFacePath = base_path("app/$forderName/Interfaces/" . ucfirst($name) . ucfirst($layerName) . 'Interface.php');
            $layerPath = base_path("app/$forderName/" . ucfirst($name) . ucfirst($layerName) . '.php');

            // Tạo file
            File::put($layerInterFacePath, $layerInterFaceContent);
            File::put($layerPath, $layerContent);

            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
            return false;
        }
    }

    private function makeModel()
    {
        $payload = request()->only('name', 'module_type');

        switch ($payload['module_type']) {
            case '1':
                // Create Template Catalogue Model
                $this->createModel($payload['name'], 'TemplateCatalogue');
                break;
            case '2':
                // Create Template Model
                $this->createModel($payload['name'], 'Template');
                break;

            default:
                // $this->createController();

                break;
        }
    }

    private function createModel($name, $templateFile)
    {
        try {
            $templateModelPath = base_path('app/Templates/' . $templateFile . 'Model.php');
            // Đọc nội dung của file
            $modelContent = file_get_contents($templateModelPath);
            // Các biến ở trong file template
            $replace = $this->getModelReplace($name, $templateFile);

            $modelContent = $this->formatContent($modelContent, $replace);
            $modelPath = base_path('app/Models/' . ucfirst($name) . '.php');
            // Tạo file
            File::put($modelPath, $modelContent);
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
            return false;
        }
    }

    private function getModelReplace($name, $templateFile)
    {
        $tableName = $this->convertModuleNameToTableName($name);
        $relation = lcfirst(explode('_', $tableName)[0]);

        $replace = [
            'ModuleTemplate' => ucfirst($name),
            'tableName' => $tableName . 's',
            'foreignKey' => $tableName . '_id',
            'pivotTable' => $tableName . '_language',
            'relationPivot' => $tableName . '_' . $relation,
            'relation' => $relation,
            'Relation' => ucfirst($relation),
        ];

        if ($templateFile == 'Template') {
            $replace['tableName'] = $tableName . '_catalogues';
            $replace['foreignKey'] = $tableName . '_catalogue_id';
            unset($replace['moduleView']);
        }

        return $replace;
    }

    private function makeController()
    {
        $payload = request()->only('name', 'module_type');

        switch ($payload['module_type']) {
            case '1':
                // Create Template Catalogue Controller
                $this->createController($payload['name'], 'TemplateCatalogue');
                break;
            case '2':
                // Create Template Controller
                $this->createController($payload['name'], 'Template');
                break;

            default:
                // $this->createController();

                break;
        }
    }


    private function createController($name, $templateFile)
    {
        try {
            $templateControllerPath = base_path('app/Templates/' . $templateFile . 'Controller.php');
            // Đọc nội dung của file
            $controllerContent = file_get_contents($templateControllerPath);

            // Các biến ở trong file template
            $replace = $this->getControllerReplace($name, $templateFile);

            $controllerContent = $this->formatContent($controllerContent, $replace);
            $controllerPath = base_path('app/Http/Controllers/Servers/' . ucfirst($name) . 'Controller.php');
            // Tạo file
            File::put($controllerPath, $controllerContent);
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
            return false;
        }
    }

    private function getControllerReplace($name, $templateFile)
    {
        $tableName = $this->convertModuleNameToTableName($name);
        $replace = [
            'ModuleTemplate' => ucfirst($name),
            'moduleTemplate' => lcfirst($name),
            'tableName' => $tableName . 's',
            'foreignKey' => $tableName . '_id',
            'moduleView' => str_replace('_', '.', $tableName),
        ];

        if ($templateFile == 'Template') {
            $replace['tableName'] = $tableName . '_catalogues';
            $replace['foreignKey'] = $tableName . '_catalogue_id';
            unset($replace['moduleView']);
        }

        return $replace;
    }


    private function makeDatabase()
    {
        try {
            $payload = request()->only('schema', 'name', 'module_type');
            // Lấy ra tên file và path migration
            $tableName = $this->convertModuleNameToTableName($payload['name']) . 's';
            $migrationFileName = date('Y_m_d_His') . '_create_' . $tableName . '_table';
            $migrationPath = database_path('migrations/' . $migrationFileName . '.php');
            $migrationTemplate = $this->createMigrationFile($payload);

            // Tạo file migration
            File::put($migrationPath, $migrationTemplate);

            if ($payload['module_type'] != 3) {
                $foreignKey = $this->convertModuleNameToTableName($payload['name']) . '_id';
                $pivotTableName = substr($tableName, 0, -1) . '_language';
                // Tạo ra pivot schema table
                $pivotSchema = $this->pivotSchema($foreignKey, $pivotTableName, $tableName);

                // Lấy ra tên file và path migration
                $migrationPivotFileName = date('Y_m_d_His', time() + 10) . '_create_' . $pivotTableName . '_table';
                $migrationPivotPath = database_path('migrations/' . $migrationPivotFileName . '.php');

                $migrationPivotTemplate = $this->createMigrationFile([
                    'schema' => $pivotSchema,
                    'name' => $pivotTableName,
                ]);

                File::put($migrationPivotPath, $migrationPivotTemplate);
            }

            Artisan::call('migrate');
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
            return false;
        }
    }

    private function formatContent($content, $replace)
    {
        foreach ($replace as $key => $value) {
            $content = str_replace('{' . $key . '}', $value, $content);
        }
        return $content;
    }

    private function pivotSchema($foreignKey = '', $pivotTableName = '', $foreignTableName = '')
    {
        $pivotSchema = <<<SCHEMA
Schema::create('{$pivotTableName}', function (Blueprint \$table) {
    \$table->foreignId('{$foreignKey}')->constrained('{$foreignTableName}')->onDelete('cascade');
    \$table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
    \$table->string('name');
    \$table->text('description');
    \$table->text('content');
    \$table->string('canonical');
    \$table->string('meta_title');
    \$table->string('meta_keyword');
    \$table->text('meta_description');
});
SCHEMA;
        return $pivotSchema;
    }
    private function createMigrationFile($payload)
    {
        // Cấu trúc PHP Heradoc
        $migrationTemplate = <<<MIGRATION
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        {$payload['schema']};
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('{$this->convertModuleNameToTableName($payload['name'])}');
    }
};
MIGRATION;
        return $migrationTemplate;
    }

    private function convertModuleNameToTableName($name)
    {
        $temp = strtolower(preg_replace('/(?<!^)([A-Z])/', '_$1', $name));
        return  $temp;
    }

    public function update($id)
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ 2 trường bên dưới
            $payload = request()->except('_token', '_method');
            $update =  $this->generateRepository->update($id, $payload);

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

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm
            $delete =  $this->generateRepository->delete($id);

            if (!$delete) {
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
}
