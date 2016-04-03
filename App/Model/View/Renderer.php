<?php
namespace App\Model\View;
use App\App;

/**
 * View renderer model
 *
 * @category   App
 * @package    App
 * @subpackage Model
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
class Renderer
{
    /**
     * Rendering variables
     *
     * @var string
     */
    protected $_layoutDir;
    protected $_templateDir;
    protected $_layout;
    protected $_template;
    /**
     * Paras for rendering
     *
     * @var array
     */
    protected $_params;

    /**
     * Renderer initialization
     *
     * @param string $template    Template name
     * @param string $layout      Layout name
     * @param array  $params      Params for rendering
     * @param string $layoutDir   Layout directory
     * @param string $templateDir Template directory
     */
    public function __construct($template, $layout = 'base', $params = [], $layoutDir = '', $templateDir = '')
    {
        $this->_layout = $layout;
        $this->_template = $template;
        $this->_params = $params;
        $this->_layoutDir = $layoutDir ?: App::getViewDir() . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR;
        $this->_templateDir = $templateDir ?: App::getViewDir() . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR;
    }

    /**
     * Prepare layout
     *
     * @return void
     */
    public function render()
    {
        require_once $this->_layoutDir . $this->_layout . '.phtml';
    }

    /**
     * Prepare template
     *
     * @return void
     */
    public function renderTemplate()
    {
        require_once $this->_templateDir . $this->_template . '.phtml';
    }

    /**
     * Get param
     *
     * @param string $param Param name
     * @return mixed
     */
    public function getData($param)
    {
        return $this->_params[$param];
    }
}
