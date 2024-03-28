<?php

namespace App\Repositories;

// ======================================
//				Contracts
// ======================================
use App\Contracts\RepositoryInterface;

// ======================================
//				Traits
// ======================================
use App\Models\User;

// ======================================
//				Illuminate
// ======================================
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;

class Repository implements RepositoryInterface
{
    // use PaginateTrait;

    /**
     * @var Model $model model.
     *
     */
    protected Model $model;

    /**
     * @var array $relations relations.
     *
     */
    private array $relations;

    /**
     * Repository constructor.
     *
     */
    public function __construct(Model $model, array $relations = [])
    {
        // Set Data
        $this->model     = $model;
        $this->relations = $relations;
    }

    /**
     * Get All.
     *
     * @return Collection
     */
    public function all() : Collection
    {
        return (!empty($this->relations))
        ? $this->model::with($this->relations)->get()
        : $this->model::orderBy('id', 'asc')->get();
    }

    /**
     * @return Collection
     */
    public function index() : Collection
    {
        return (!empty($this->relations))
        ? $this->model::with($this->relations)->get()
        : $this->model::get();
    }

    public function get(int $id) : Collection
    {
        return (!empty($this->relations))
        ? $this->model::with($this->relations)->whereId($id)->get()
        : $this->model::get();
    }

    /**
     * Find.
     *
     * @param  mixed  $data
     * @return Model
     */
    public function find($data) : Model
    {
        return $this->model::with($this->relations)->find($data);
    }

    /**
     * First Or New.
     *
     * @param  mixed  $data
     * @return Model
     */
    public function firstOrNew($data) : Model
    {
        return $this->model::firstOrNew($data);
    }

    /**
     * Where.
     *
     * @param  mixed  $attribute
     * @param  mixed  $data
     * @return \Illuminate\Http\Response
     */
    public function where($attribute, $data)
    {
        return $this->model::with($this->relations)->where($attribute, $data);
    }

    /**
     * WhereDiff.
     *
     * @param  mixed  $attribute
     * @param  mixed  $data
     * @return \Illuminate\Http\Response
     */
    public function whereDiff($attribute, $data)
    {
        return $this->model::with($this->relations)->where($attribute, '!=', $data);
    }

    /**
     * Where In.
     *
     * @param  mixed  $atribute
     * @param  mixed  $data
     * @return \Illuminate\Http\Response
     */
    public function whereIn($atribute, $data)
    {
        return $this->model::with($this->relations)->whereIn($atribute, $data);
    }

    /**
     * Where Not In.
     *
     * @param  mixed  $atribute
     * @param  mixed  $data
     * @return \Illuminate\Http\Response
     */
    public function whereNotIn($atribute, $data)
    {
        return $this->model::with($this->relations)->whereNotIn($atribute, $data);
    }

    /**
     * Where Raw.
     *
     * @param  mixed  $query
     * @param  mixed  $variables
     * @return \Illuminate\Http\Response
     */
    public function whereRaw($query, $variables)
    {
        return $this->model::with($this->relations)->whereRaw($query, $variables);
    }

    /**
     * Create.
     *
     * @param  array  $data
     * @return Model
     */
    public function create(array $data) : Model
    {
        return $this->model::create($data);
    }

    public function paginate($relations = null, $paginate = 20)
    {
        return (!empty($this->relations))
            ? $this->model::with($this->relations)->orderBy('id', 'desc')->paginate($paginate)
            : $this->model::orderBy('id', 'desc')->paginate($paginate);

    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        $update = $this->model->find($id);
        $update->update($data);

        return $update;
    }

    /**
     * Save.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return boolean
     */
    public function save(Model $model)
    {
        return $model->saveOrFail();
    }

    /**
     * Delete.
     *
     * @param  mixed  $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function delete($data)
    {
        return $this->model::findOrFail($data)->delete();
    }

    /**
     * Create Entity.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function createEntity(Request $request)
    {
        return $this->model::create($request->all());
    }

    /**
     * Update Entity.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return void
     */
    public function updateEntity(Request $request, int $id)
    {
        $entity = $this->model::find($id);

        $entity->update($request->all());

        $entity->save();

        return $entity;
    }

    /**
     * Delete Entity.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return void
     */
    public function deleteEntity(int $id)
    {
        $entity = $this->model::find($id);

        $entity->delete();
    }
}
