<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    symfony.runtime.addon
 * @author     Sebastian Barthenheier <tauven@gmail.com>
 * @version    0.1
 */


/**
 *
 * This is taken from Fabien Potencier's Thumbnail class for Symfony and 
 * modified to crop an image.
 *
 * @package    symfony.runtime.addon
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfThumbnail.class.php 1199 2006-04-13 16:07:18Z fabien $
 */

/**
 *
 * This is taken from Harry Fueck's Thumbnail class and 
 * converted for PHP5 strict compliance for use with symfony.
 *
 * @package    symfony.runtime.addon
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfThumbnail.class.php 1199 2006-04-13 16:07:18Z fabien $
 */
class sfCrop
{
  /**
  * Maximum width of the thumbnail in pixels
  * @access private
  * @var int
  */
  private $maxWidth;

  /**
  * Maximum height of the thumbnail in pixels
  * @access private
  * @var int
  */
  private $maxHeight;

  /**
  * Whether to scale image to fit thumbnail (true) or
  * strech to fit (false)
  * @access private
  * @var boolean
  */
  private $scale;

  /**
  * Whether to inflate images smaller the the thumbnail
  * @access private
  * @var boolean
  */
  private $inflate;

  /**
  * List of accepted image types based on MIME description
  * @access private
  * @var array
  */
  private $imgTypes;

  /**
  * Stores function names for each image type e.g. imagecreatefromjpeg
  * @access private
  * @var array
  */
  private $imgLoaders;

  /**
  * Stores function names for each image type e.g. imagejpeg
  * @access private
  * @var array
  */
  private $imgCreators;

  /**
  * The source image
  * @access private
  * @var resource
  */
  private $source;

  /**
  * Width of source image in pixels
  * @access private
  * @var int
  */
  private $sourceWidth;

  /**
  * Height of source image in pixels
  * @access private
  * @var int
  */
  private $sourceHeight;

  /**
  * MIME type of source image
  * @access private
  * @var string
  */
  private $sourceMime;

  /**
  * The thumbnail
  * @access private
  * @var resource
  */
  private $thumb;

  /**
  * Width of thumbnail in pixels
  * @access private
  * @var int
  */
  private $thumbWidth;

  /**
  * Height of thumbnail in pixels
  * @access private
  * @var int
  */
  private $thumbHeight;

  /**
  * Image data from call to GetImageSize needed for saveThumb
  * @access private
  * @var resource
  */
  private $imgData;

  /**
  * Thumbnail constructor
  * @param int max width of cropped image
  * @param int max height of cropped image
  * @param int source x point
  * @param int source y point
  * @param int source width point
  * @param int source height point
  * @param boolean (optional) if true image scales
  * @param boolean (optional) if true inflate small images
  * @access public
  */
  public function __construct($maxWidth, $maxHeight,$srcx=0, $srcy=0,$srcw=0, $srch=0, $scale = true, $inflate = false)
  {
    $this->maxWidth  = $maxWidth;
    $this->maxHeight = $maxHeight;
    $this->srcy  = $srcy;
    $this->srcx = $srcx;
    if($srcw>0&&$srch>0) {
        $this->sourceWidth  = $srcw;
        $this->sourceHeight = $srch;
    }
    else
    {
        $this->sourceWidth  = $this->maxWidth;
        $this->sourceHeight = $this->maxHeight;
    }
    $this->scale     = $scale;
    $this->inflate   = $inflate;

    $this->imgTypes = array('image/jpeg', 'image/png', 'image/gif');
    $this->imgLoaders = array(
      'image/jpeg' => 'imagecreatefromjpeg',
      'image/png'  => 'imagecreatefrompng',
      'image/gif'  => 'imagecreatefromgif',
    );

    $this->imgCreators = array(
      'image/jpeg' => 'imagejpeg',
      'image/png'  => 'imagepng',
      'image/gif'  => 'imagegif',
    );
  }

  /**
  * Loads an image from a file
  * @param string filename (with path) of image
  * @return boolean
  * @access public
  * @throws Exception
  */
  public function loadFile($image)
  {
    $imgData = @GetImageSize($image);

    if (!$imgData)
    {
      throw new Exception("Could not load image $image");
    }

    if (in_array($imgData['mime'], $this->imgTypes))
    {
      $loader = $this->imgLoaders[$imgData['mime']];
      $this->source = $loader($image);
      $this->sourceMime = $imgData['mime'];
      $this->imgData = $imgData;
      $this->initThumb();

      return true;
    }
    else
    {
      throw new Exception('Image MIME type '.$imgData['mime'].' not supported');
    }
  }

  /**
  * Loads an image from a string (e.g. database)
  * @param string the image
  * @param mime mime type of the image
  * @return boolean
  * @access public
  * @throws Exception
  */
  function loadData ($image, $mime)
  {
    if (in_array($mime,$this->imgTypes))
    {
      $this->source=imagecreatefromstring($image);
      $this->sourceMime=$mime;
      $this->initThumb();

      return true;
    }
    else
    {
      throw new Exception('Image MIME type '.$mime.' not supported');
    }
  }

  /**
  * Returns the mime type for the image
  * @return string
  * @access public
  */
  function getMime()
  {
    return $this->sourceMime;
  }

  /**
  * Returns the width of the cropped image
  * @return int
  * @access public
  */
  function getThumbWidth()
  {
    return $this->thumbWidth;
  }

  /**
  * Returns the height of the cropped image
  * @return int
  * @access public
  */
  function getThumbHeight()
  {
    return $this->thumbHeight;
  }

  /**
  * Creates the cropped image
  * @return void
  * @access private
  */
  private function initThumb()
  {

    if ($this->scale)
    {
      if ($this->sourceWidth > $this->sourceHeight)
      {
        $this->thumbWidth=$this->maxWidth;
        $this->thumbHeight=floor($this->sourceHeight*($this->maxWidth/$this->sourceWidth));
      }
      else if ($this->sourceWidth < $this->sourceHeight)
      {
        $this->thumbHeight=$this->maxHeight;
        $this->thumbWidth=floor($this->sourceWidth*($this->maxHeight/$this->sourceHeight));
      }
      else
      {
        $this->thumbWidth=$this->maxWidth;
        $this->thumbHeight=$this->maxHeight;
      }
    }
    else
    {
      $this->thumbWidth=$this->maxWidth;
      $this->thumbHeight=$this->maxHeight;
    }

    $widthResized = ceil( $this->thumbWidth / ( $this->sourceHeight / $this->sourceWidth ) );
    $heightResized = $this->thumbHeight + 5;

    $x = ( $this->thumbWidth - $widthResized ) / 2;

    $this->thumb = imagecreatetruecolor($this->thumbWidth, $this->thumbHeight);
    $white = imagecolorallocate($this->thumb, 255, 255, 255);
    imagefill($this->thumb, 0, 0, $white);
    imagecopyresampled( $this->thumb, $this->source, $x, 0, $this->srcx, $this->srcy, $widthResized, $heightResized, $this->sourceWidth,$this->sourceHeight);
  }

  /**
  * Saves the cropped image to the filesystem
  * @access public 
  * @return void
  */
  public function save($thumbDest, $creatorName = null)
  {
    $creator = $creatorName !== null ? $this->imgCreators[$creatorName] : $this->imgCreators[$this->imgData['mime']];
    $creator($this->thumb, $thumbDest);
  }
}

?>
