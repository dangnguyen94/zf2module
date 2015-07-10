<?php

namespace File\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
*
* File
*
* @ORM\Table(name="file")
* @ORM\Entity
*/
class File
{
	/**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

     /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="string", nullable=false)
     */
    private $thumbnail;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", nullable=false)
     */
    private $url;

    public function getId()
    {
    	return $this->id;
    }

    public function setUrl($url)
    {
    	$this->url = $url;
    }

    public function getUrl()
    {
    	return $this->url;
    }

    public function setThumbnail()
    {
    	// $urlArr = split("/", $this->url);
    	// $name = $urlArr[sizeof($urlArr)-1];
    	// $this->thumbnail = $name.'.jpg';
        $extend = pathinfo($this->url, PATHINFO_EXTENSION);
        if ($extends == 'pdf') {
            $this->thumbnail = $this->url.'.jpg';
            $source = "/var/www/zf2module/public/uploads/".$this->url;
            //$this->genPdfThumbnail($this->url,$this->thumbnail);
            $this->genPdfThumbnail($source,$this->thumbnail);
        } else {
            $this->thumbnail = '';
        }
        
    }

    public function getThumbnail()
    {
    	return $this->thumbnail;
    }
    // may be try https://www.scribd.com/developers/platform/api/thumbnail_get
    function genPdfThumbnail($source, $target)
	{
	    //$source = realpath($source);
	    //$target = dirname($source).DIRECTORY_SEPARATOR.$target;
	    $im = new \Imagick($source."[0]"); // 0-first page, 1-second page
	    $im->setImageColorspace(255); // prevent image colors from inverting
	    $im->setimageformat("jpeg");
	    $im->thumbnailimage(160, 120); // width and height
	    $im->writeimage("/var/www/zf2module/public/uploads/".$target);
	    $im->clear();
	    $im->destroy();
	}
}