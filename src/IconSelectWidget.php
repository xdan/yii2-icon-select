<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 5/17/16
 * Time: 1:34 PM
 */

namespace xdan;


use xdan\IconSelectWidgetAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use Yii;

class IconSelectWidget extends \yii\base\Widget
{
    public $model;
    public $attribute;

    /**
     * items array
     * */
    public $items = [];

    /**
     * widget wrapper tag options
     * */
    public $wrapperOptions = [];

    /**
     * activeInput options
     */
    public $options = [];

    /**
     * iconSelect plugin options
     * */
    public $pluginOptions = [];

    protected $pluginId = null;
    protected $inputId = null;
    protected $asset;

    static $inputCounter = 0;

    public function run()
    {
        if (empty($this->items)) {
            return null;
        }
        $this->prepare();
        $this->prepareScript();

        return $this->renderWidget();
    }

    /**
     * @return boolean
     */
    protected function prepare()
    {
        $this->asset = IconSelectWidgetAsset::register($this->view);
        $this->pluginId = $this->getId();
        $this->inputId = $this->getInputId();
        $this->pluginOptions = ArrayHelper::merge([
            'selectedIconWidth' => 24,
            'selectedIconHeight' => 24,
            'selectedBoxPadding' => 1,
            'iconsWidth' => 48,
            'iconsHeight' => 48,
            'boxIconSpace' => 1,
            'vectoralIconNumber' => 4,
            'horizontalIconNumber' => 6
        ], $this->pluginOptions);
    }

    /**
     * @return string
     */
    protected function renderWidget()
    {
        $pluginTagOptions = [
            'id' => $this->pluginId,
        ];
        $inputOptions = ArrayHelper::merge($this->options, [
            'id' => $this->inputId,
        ]);
        $input = Html::activeHiddenInput($this->model, $this->attribute, $inputOptions);
        $pluginBlock = Html::tag('div', null, $pluginTagOptions);
        $wrapper = Html::tag('div', $input . $pluginBlock, $this->wrapperOptions);

        return $wrapper;
    }

    /**
     * @return void
     */
    protected function prepareScript()
    {
        $imageWebPath = $this->asset->baseUrl . '/images/control/icon-select/arrow.png';
        $script = "IconSelect.COMPONENT_ICON_FILE_PATH = '$imageWebPath';\n";

        $items = [];
        foreach ($this->items as $key => $item) {
            $items[] = [
                'iconFilePath' => $item,
                'iconValue' => $key,
            ];
        }

        $itemsEncoded = Json::encode($items);
        $pluginOptions = Json::encode($this->pluginOptions);

        $script .= "jQuery(window).on('load', function() { ";

        $script .=      "iconSelect = new IconSelect('$this->pluginId', $pluginOptions);";
        $script .=      "var icons = $itemsEncoded;";
        $script .=      "iconSelect.refresh(icons);";

        if ($this->model[$this->attribute]) {
            $index = $this->model[$this->attribute];
            if (!is_numeric($index)) {
	            $index = array_search($index, array_values($this->items));
            }
	        $script .=  "iconSelect.setSelectedIndex($index);";
        }

        $script .=      "var selectedItem = document.getElementById('$this->inputId');";
        $script .=      "document.getElementById('$this->pluginId').addEventListener('changed', function(e) {";
        $script .=          "selectedItem.value = iconSelect.getSelectedValue();";
        $script .=      "})";

        $script .= "});";

        $this->view->registerJs($script);
    }

    /**
     * @return string
     */
    protected function getInputId()
    {
        if (!$this->pluginId) {
            static::$inputCounter++;
            return $this->pluginId . '_' . static::$inputCounter;
        }

        return 'q' . static::$inputCounter;
    }
}