<?php

namespace Oxygencms\Core\Traits;

trait CommonAccessors
{
    /**
     * Get the name of the model.
     *
     * @return string
     */
    public function getModelNameAttribute(): string
    {
        $path = explode('\\', get_called_class());

        return array_pop($path);
    }

    /**
     * Get the url to show a model's instance.
     *
     * @return string
     */
    public function getShowUrlAttribute(): string
    {
        return $this->getUrlFor('show');
    }

    /**
     * Get the url to edit a model's instance.
     *
     * @return string
     */
    public function getEditUrlAttribute(): string
    {
        return $this->getUrlFor('edit');
    }

    /**
     * Get the url to update a model's instance.
     *
     * @return string
     */
    public function getUpdateUrlAttribute(): string
    {
        return $this->getUrlFor('update');
    }

    /**
     * @param string $suffix
     *
     * @return bool|string
     */
    protected function getUrlFor(string $suffix): string
    {
        $model_name = strtolower($this->model_name);

        if (isset($this->route_name_prefixes)) {

            $route_name = implode('.', $this->route_name_prefixes) . ".$model_name.$suffix";

            return route('admin.' . $route_name, $this->getRouteParams());
        }

        // show url
        if ($suffix == 'show') {
            $route_key = $this->model_name == 'Page'
                ? $this->slug
                : $this->getRouteKey();

            return route($model_name . ".$suffix", $route_key);
        }

        return route('admin.' . $model_name . ".$suffix", $this->getRouteKey());
    }
}
