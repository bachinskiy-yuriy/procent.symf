<?php
namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\Table(name="posts")
 * @ORM\Entity
 */
class Post implements Translatable
{
    /** @ORM\Id @ORM\GeneratedValue @ORM\Column(type="integer") */
    private $id;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(length=128)
     */
    private $title;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @Gedmo\Locale
     * Используется для переопределения локали Translation слушателя
     * это простое свойство класса и не отображает поле в базе данных
     * определять это свойство не обязательно, поскольку оно будет автоматически
     * установлено Translation слушателем
     */
    private $locale;

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
}