<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// Hàm này giúp tính toán lại các giá trị left right
class Nestedsetbie
{

	function __construct($params = NULL)
	{
		$this->params = $params;
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
		$foreignkey = (isset($this->params['foreignkey'])) ? $this->params['foreignkey'] : 'post_catalogue_id';

		$moduleExtract = explode('_', $this->params['table']);

		$isMenu = isset($this->params['isMenu']) && $this->params['isMenu'] == true;
		$catalogue = $isMenu ? '' : '_catalogue';
		$join = $isMenu ? substr($moduleExtract[0], 0, -1) : $moduleExtract[0];

		$columns = [
			'tb1.id', 'tb2.name', 'tb1.parent_id', 'tb1.left', 'tb1.right', 'tb1.level', 'tb1.order'
		];

		if ($isMenu) {
			$columns[] = 'tb1.menu_catalogue_id';
		}

		$result = DB::table($this->params['table'] . ' as tb1')
			->select($columns)
			->join($join . $catalogue . '_language as tb2', 'tb1.id', '=', 'tb2.' . $foreignkey . '')
			->where('tb2.language_id', '=', $this->params['language_id'])
			->whereNull('tb1.deleted_at')
			->orderBy('tb1.left', 'asc')
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
					'user_id' => Auth::id(),
				];

				if (isset($this->params['isMenu']) && $this->params['isMenu'] == true) {
					$item['menu_catalogue_id'] = $this->data[0]->menu_catalogue_id;
				}

				$data[] = $item;
			}

			if (isset($data) && is_array($data) && count($data)) {
				DB::table($this->params['table'])->upsert($data, 'id', ['level', 'left', 'right']);
			}
		}
	}

	public function Dropdown($param = NULL)
	{
		$this->get();
		if (isset($this->data) && is_array($this->data)) {
			$temp = NULL;
			$temp[0] = (isset($param['text']) && !empty($param['text'])) ? $param['text'] : '[Root]';
			foreach ($this->data as $key => $val) {
				$temp[$val->id] = str_repeat('|-----', (($val->level > 0) ? ($val->level - 1) : 0)) . $val->name;
			}
			return $temp;
		}
	}
}
