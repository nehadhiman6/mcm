<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ModelUtilities
{

  /**
   * Create an array of new instances of the related model.
   *
   * @param  array  $records
   * @return array
   */
    public static function createOrUpdateMany($records, array $additional_attributes = [], array $idarr = [])
    {
        $instances = [];
        $idarr = static::removeExistingIds($records, $idarr);
//    var_dump($idarr);
        foreach ($records as $record) {
            $arr = static::getID($record, $idarr);
            $idarr = $arr[0];
            $id = $arr[1];
            if ($id == 0) {
                $instances[] = static::appCreate($record, $additional_attributes);
            } else {
                $instances[] = static::findAndUpdate($record, $id, $additional_attributes);
            }
        }
        static::remove($idarr);
        return $instances;
    }

    /**
     * removes existing ids that are in modified list.
     *
     * @param  array  $records
     * @return array
     */
    public static function removeExistingIds($records, $arr)
    {
        foreach ($records as $rec) {
            if (data_get($rec, 'id', null) != null) {
                $id = data_get($rec, 'id');
                if (array_key_exists($id, $arr)) {
                    unset($arr[$id]);
                }
            }
        }
        reset($arr);
        return $arr;
    }

    public static function findAndUpdate($record, $id, array $additional_attributes = [])
    {
        $model = static::find($id);
        if (is_array($record)) {
            $model->fill($record);
        } else {
            $model->fill($record->attributesToArray());
        }
        $model->fillAdditionalAttributes($additional_attributes);
        return $model->save();
    }

    public static function appCreate($modelArr, array $additional_attributes = [])
    {
        if (is_array($modelArr)) {
            $model = new static($modelArr);
            $model->fillAdditionalAttributes($additional_attributes);
            $model->save();
            return $model;
        } else {
            $modelArr->fillAdditionalAttributes($additional_attributes);
            $modelArr->save();
            return $modelArr;
        }
    }

    public function fillAdditionalAttributes(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }

    public function fillFillable($record)
    {
        foreach ($record as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function remove(array $idarr)
    {
        foreach ($idarr as $key => $value) {
            $model = static::find($key);
            if ($model) {
                $model->delete();
            }
        }
    }

    private static function getID($record, $idarr)
    {
        $id = 0;
        if (data_get($record, 'id', null) <> null) {
            $id = data_get($record, 'id');
            if (array_key_exists($id, $idarr)) {
                unset($idarr[$id]);
                reset($idarr);
            }
            return [$idarr, $id];
        } else {
            return getFirstKey($idarr);
        }
    }

    public function setAttribute($key, $value)
    {
        // First we will check for the presence of a mutator for the set operation
        // which simply lets the developers tweak the attribute as it is set on
        // the model, such as "json_encoding" an listing of data for storage.
        if ($this->hasSetMutator($key)) {
            $method = 'set' . Str::studly($key) . 'Attribute';

            return $this->{$method}($value);
        }

        // If an attribute is listed as a "date", we'll convert it from a DateTime
        // instance into a form proper for storage on the database tables using
        // the connection grammar's date format. We will auto set the values.
        elseif ($value && (in_array($key, $this->getDates()) || $this->isDateCastable($key))) {
            $value = $this->fromDateTime($value);
        }

        if ($this->isJsonCastable($key) && !is_null($value)) {
            $value = $this->asJson($value);
        }

        if ($this->isNumberCastable($key)) {
            $value = $this->castAsNumber($key, $value);
        }

        $this->attributes[$key] = $value;

        return $this;
    }

    protected function isNumberCastable($key)
    {
        if (isset($this->numbers)) {
            return array_key_exists($key, $this->numbers);
        }
        return false;
    }

    protected function castAsNumber($key, $value)
    {
        if (is_null($value)) {
            return $value;
        }

        switch (trim(strtolower($this->numbers[$key]))) {
      case 'int':
      case 'integer':
        return (int) $value;
      case 'real':
      case 'float':
      case 'double':
        return (float) $value;
      default:
        return $value;
    }
    }
}
