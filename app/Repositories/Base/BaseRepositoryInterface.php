<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{

    /**
     * Create a new model instance and store it in the database.
     *
     * @param  array  $attributes  The attributes to create the model with.
     *
     * @return Model The created model instance.
     */
    public function create(array $attributes): Model;

    /**
     * Retrieve a collection of relations.
     *
     * @param  array  $relations  An array of relations to retrieve.
     *
     * @return Collection A collection of retrieved relations.
     */
    public function all(array $relations = []): Collection;

    /**
     * Find an entity by its ID.
     *
     * @param  Model  $model  The model instance to find by ID.
     *
     * @return Model The found model instance or null if not found.
     */
    public function find(Model $model): Model;

    /**
     * Update the given model.
     *
     * @param  array  $payload  The data to update.
     * @param  Model  $model    The model instance to be updated.
     *
     * @return Model The updated model instance.
     */
    public function update(array $payload, Model $model): Model;

    /**
     * Deletes a model.
     *
     * @param  Model  $model  The model to be deleted.
     *
     * @return bool True if the model was deleted successfully
     */
    public function delete(Model $model): bool;

    /**
     * Find the model matching the given attributes or create it if not found.
     *
     * @param  array  $attributes  The attributes to search for or create.
     *
     * @return Model The found or newly created model.
     */
    public function firstOrCreate(array $attributes): Model;

    /**
     * Find and return a model by specified criteria.
     *
     * @param  array  $criteria  The criteria to search for.
     *
     * @return Model|null The found model, or null if not found.
     */
    public function findByCriteria(array $criteria): ?Model;

}
