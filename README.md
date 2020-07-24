# fileAway pseudo database

Test, Mock, Store, Show, Develop faster examples, mock-APIs and apps.

This "database" solution is meant for rapid development and not intended 
to be used in production. If used in production, please consider the following:

- is the location of the json-file secure? (e.g. protect via .htaccess in apache)
- will I require scalability or handling of bigger datasets? (If so: this is not your production solution!)

## Installation

`composer require neoan3-apps/file-away`

## Usage

```PHP
$db = new \Neoan3\Apps\FileAway('storage.json');

// add entry to new or existing entity
$db->setEntity('articles') // set current entity
   ->add(['title'=>'demo post', 'content' => 'such text']) // add entry to entity
   ->save() // write to db

// list all entries (NOTE: we assume that the entity is still set)
foreach($db->find() as $post) {
    echo $post->title . "<br>";
}

// find one
echo $db->findOne(['title' => 'demo post'])->content;

```