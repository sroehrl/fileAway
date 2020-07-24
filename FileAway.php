<?php


namespace Neoan3\Apps;


class FileAway
{
    private string $file;
    private object $data;
    private string $entity;

    function __construct($file = __DIR__ . '/data.json')
    {
        $this->file = $file;
        if (!file_exists($this->file)) {
            file_put_contents($this->file, json_encode(new \stdClass()));
        }
        $this->data = json_decode(file_get_contents($this->file));
    }

    private function read($what): ?array
    {
        if (isset($this->data->$what)) {
            return $this->data->$what;
        }
        return null;
    }

    function save()
    {
        file_put_contents($this->file, json_encode($this->data));
    }

    function setEntity($entity): FileAway
    {
        $this->entity = $entity;
        if (!$this->read($entity)) {
            $this->data->$entity = [];
        }
        return $this;
    }

    function delete($condition)
    {
        $deletable = $this->find($condition);

        foreach ($deletable as $key => $any) {
            unset($this->data->{$this->entity}[$key]);
        }
        $this->save();
        return $this;
    }

    function findOne($condition): ?object
    {
        $hits = $this->find($condition);
        if (!empty($hits)) {
            return reset($hits);
        }
        return null;
    }

    function find($condition = []): array
    {
        $return = [];
        if (empty($condition)) {
            $return = $this->data->{$this->entity};
        } else {
            foreach ($this->data->{$this->entity} as $index => $entry) {
                $hit = false;
                foreach ($condition as $conditionKey => $conditionValue) {
                    $hit = isset($entry->$conditionKey) && $entry->$conditionKey == $conditionValue;
                }
                if ($hit) {
                    $return[$index] = $entry;
                }

            }
        }

        return $return;
    }

    function add($content): FileAway
    {
        $this->data->{$this->entity}[] = (object)$content;
        return $this;
    }
}