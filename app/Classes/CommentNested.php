<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;

// Hàm này giúp tính toán lại các giá trị left right
class CommentNested
{

    function __construct($params = NULL, $payload = NULL)
    {
        $this->params = $params;
        $this->payload = $payload;
        $this->checked = NULL;
        $this->data = NULL;
        $this->count = 0;
        $this->count_level = 0;
        $this->left = NULL;
        $this->right = NULL;
        $this->level = NULL;
    }

    public function Get()
    {
        $columns = [
            'id', 'parent_id', 'left', 'right', 'level'
        ];

        $result = DB::table($this->params['table'] . ' as tb1')
            ->select($columns)
            ->orderBy('left', 'asc')
            ->where('commentable_type', $this->params['commentable_type'])
            ->get()
            ->toArray();
        $this->data = $result;
        // dd($result);
    }

    public function Set()
    {
        if (isset($this->data) && is_array($this->data)) {
            $arr = NULL;
            foreach ($this->data as $key => $val) {
                $arr[$val->id][$val->parent_id] = 1;
                $arr[$val->parent_id][$val->id] = 1;
            }
            return $arr;
        }
    }

    public function Recursive($start = 0, $arr = NULL)
    {
        // Dùng đệ quy để tính toán các giá trị left right
        $this->left[$start] = ++$this->count;
        $this->level[$start] = $this->count_level;
        if (isset($arr) && is_array($arr)) {
            foreach ($arr as $key => $val) {
                if ((isset($arr[$start][$key]) || isset($arr[$key][$start])) && (!isset($this->checked[$key][$start]) && !isset($this->checked[$start][$key]))) {
                    $this->count_level++;
                    $this->checked[$start][$key] = 1;
                    $this->checked[$key][$start] = 1;
                    $this->recursive($key, $arr);
                    $this->count_level--;
                }
            }
        }
        $this->right[$start] = ++$this->count;
    }

    public function Action()
    {
        if (isset($this->level) && is_array($this->level) && isset($this->left) && is_array($this->left) && isset($this->right) && is_array($this->right)) {

            $data = [];
            foreach ($this->level as $key => $val) {
                if ($key == 0) continue;

                $item = [
                    'id' => $key,
                    'level' => $val,
                    'left' => $this->left[$key],
                    'right' => $this->right[$key],
                    'commentable_id' => $this->payload['commentable_id'],
                    'commentable_type' => $this->payload['commentable_type'],
                    'fullname' => $this->payload['fullname'],
                    'email' => $this->payload['email'],
                    'phone' => $this->payload['phone'],
                    'description' => $this->payload['description'] ?? '',
                    'rate' => $this->payload['rate'],

                ];

                $data[] = $item;
            }

            if (isset($data) && is_array($data) && count($data)) {
                DB::table($this->params['table'])->upsert($data, 'id', ['level', 'left', 'right']);
            }
        }
    }
}
