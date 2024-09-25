<?php
class CustomElementorWidgets
{
    protected static $instance = null;

    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected function __construct()
    {
        require_once 'filter-post-by-cat.php';

        add_action('elementor/widgets/register', [$this, 'registerWidgets']);
    }

    public function registerWidgets()
    {
        \Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\FilterPostByCat());
    }
}

function addElementorWidgetCategories($elements_manager)
{
    $categories = [];
    $categories['ecogreensupplies'] =
        [
            'title' => __('RMA', 'rma'),
            'icon' => 'fa fa-plug',
        ];

    $old_categories = $elements_manager->get_categories();
    $categories = array_merge($categories, $old_categories);

    $set_categories = function ($categories) {
        $this->categories = $categories;
    };

    $set_categories->call($elements_manager, $categories);
}
add_action('elementor/elements/categories_registered', 'addElementorWidgetCategories');

add_action('init', 'customElementorInit');
function customElementorInit()
{
    CustomElementorWidgets::getInstance();
}
