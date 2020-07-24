<?php


use Neoan3\Apps\FileAway;
use PHPUnit\Framework\TestCase;

class FileAwayTest extends TestCase
{
    private string $location = __DIR__ . '/data.json';

    static function tearDownAfterClass(): void
    {
        unlink(__DIR__ . '/data.json');
    }

    public function testInitiate()
    {
        $db = new FileAway($this->location);
        $this->assertFileExists($this->location);
    }

    public function testAddAndSave()
    {
        $db = new FileAway($this->location);
        $condition = ['key'=>'value'];
        $db->setEntity('test')
            ->add($condition);
        $this->assertEquals('value', $db->findOne($condition)->key);
        $db->save();

        $db2 = new FileAway($this->location);
        $db2->setEntity('test');
        $this->assertEquals('value', $db->findOne($condition)->key);
    }

    public function testDelete()
    {
        $db = new FileAway($this->location);
        $data = ['id' => 3];
        $db->setEntity('test')->add($data)->save();
        $this->assertEquals(3, $db->findOne($data)->id);
        $db->delete($data);
        $this->assertNull($db->findOne($data));
    }

    public function testFindAll()
    {
        $db = new FileAway($this->location);
        $data = ['tag'=>'sam'];
        $db->setEntity('tags')
            ->add($data)
            ->add($data);
        $this->assertCount(2, $db->find());
    }

}
