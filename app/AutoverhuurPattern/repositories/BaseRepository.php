<?php
/**
 * Created by PhpStorm.
 * User: JohnnyD
 * Date: 5/12/2016
 * Time: 8:14 PM
 */

namespace App\AutoverhuurPattern\Repositories;



abstract class BaseRepository {

    protected $model;
    public function __construct($model) {
        $this->model = $model;
    }
    public function all(array $related = null) {
        return $this->model->all();
    }
    public function get($id, $related = null) {
        if (isset($related))
            return $this->model->find($id)->has($related)->get();
        else
            return $this->model->find($id);
    }
    public function getWhere($column, $value, array $related = null) {
        return $this->model->where($column, '=', $value)->get();
    }
    public function getRecent($limit, array $related = null) {
        return $this->model->where($column, '=', $value)->take($limit);
    }
    public function create(array $data,$user,$aantalbeschikbaar) {
        return $this->model->create($data);
    }
    public function update(array $data,$user,$aantalbeschikbaar) {
        $user = $this->get($data['id']);
        foreach($data as $key => $value) {
            $user->$key = $value;
        }
        return $user->save();
    }
    public function delete($id) {
        return $this->model->destroy($id);
    }
    public function deleteWhere($column, $value) {
        return $this->model->where($column, '=', $value)->delete();
    }

}