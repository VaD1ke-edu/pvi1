<?php
namespace App\Model\File;
use App\App;

/**
 * File uploader
 *
 * @category   App
 * @package    App
 * @subpackage Model
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class Uploader
{
    /**
     * Media directory path
     */
    const MEDIA_DIR = 'public/media';

    /**
     * Allowed file extensions
     * @var array
     */
    protected $_allowedFileExtensions;
    /**
     * File data
     * @var array
     */
    protected $_fileData = [];
    /**
     * File uploading path
     * @var string
     */
    protected $_path;
    /**
     * File field name
     * @var string
     */
    protected $_fileFieldName;

    /**
     * Uploader constructor
     */
    public function __construct()
    {
        $this->_allowedFileExtensions = ['jpeg', 'jpg', 'png', 'gif'];
    }

    /**
     * Upload image
     *
     * @return string
     */
    public function upload()
    {
        if (!$this->_fileData || !isset($this->_fileData['name']) ||
            !file_exists($this->_fileData['tmp_name'][$this->_fileFieldName]) || !$this->_path) {
            return '';
        }

        $dirPath = $this->_getMediaPath() . $this->_path;
        
        if (!is_dir($dirPath)) {
            @mkdir($dirPath, 0777);
        }
        $newFileName = $this->_getFileName($this->_fileData['name'][$this->_fileFieldName]);
        $newFilePath = $dirPath . DIRECTORY_SEPARATOR . $newFileName;
        if (copy($this->_fileData['tmp_name'][$this->_fileFieldName], $newFilePath)) {
            return $this->_path . DIRECTORY_SEPARATOR . $newFileName;
        }
        return '';
    }


    /**
     * Set file data (from $_FILES)
     *
     * @param array $fileData File data
     * @return $this
     */
    public function setFileData(array $fileData)
    {
        $this->_fileData = $fileData;
        return $this;
    }

    /**
     * Set path
     *
     * @param string $path File uploading path
     * @return $this
     */
    public function setPath($path)
    {
        $this->_path = $path;
        return $this;
    }

    /**
     * Set allowed file extensions
     *
     * @param array $extensions Extensions
     * @return $this
     */
    public function setAllowedExtensions(array $extensions)
    {
        $this->_allowedFileExtensions = $extensions;
        return $this;
    }

    /**
     * Set file field name (from $_FILES)
     *
     * @param string $fieldName File field name
     * @return $this
     */
    public function setFileFieldName($fieldName)
    {
        $this->_fileFieldName = $fieldName;
        return $this;
    }


    /**
     * Get media path
     *
     * @return string
     */
    protected function _getMediaPath()
    {
        return App::getRootDir() . DIRECTORY_SEPARATOR . self::MEDIA_DIR .  DIRECTORY_SEPARATOR;
    }

    /**
     * Get file name
     *
     * @param string $file File path
     * @return string
     */
    protected function _getFileName($file)
    {
        return sha1($file) . '_' . time() . '.' . pathinfo($file)['extension'];
    }
}
