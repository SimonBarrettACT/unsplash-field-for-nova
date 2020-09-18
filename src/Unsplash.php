<?php

namespace Simonbarrettact\Unsplash;

use Illuminate\Support\Arr;
use Laravel\Nova\Fields\Field;

/**
 * Class Unsplash
 * @package Simonbarrettact\Unsplash
 */
class Unsplash extends Field
{
    /**
     * @var string
     */
    public $queryPlaceholder = 'Enter a topic to search for';

    /**
     * @var string
     */
    public $orientation = '';

    /**
     * @var bool
     */
    public $featured = true;

    /**
     * @var string
     */
    public $previewSize = 'small';

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'unsplash';


    /**
     * Unsplash constructor.
     *
     * @param $name
     * @param null $attribute
     * @param callable|null $resolveCallback
     */
    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta([
            'unsplashKey' => env('UNSPLASH_ACCESS_KEY', ''),
            'queryPlaceholder' => $this->queryPlaceholder,
            'orientation' => $this->orientation,
            'featured' => $this->featured,
            'previewSize' => $this->previewSize
        ]);

    }

    /**
     * Set the text to display in the query input
     *
     * @param string $queryPlaceholder
     * @return Unsplash
     */
    public function queryPlaceholder(string $queryPlaceholder)
    {
        $this->queryPlaceholder = $queryPlaceholder;
        return $this->withMeta(['queryPlaceholder' => $this->queryPlaceholder]);
    }

    /**
     * Choose the photo orientation (landscape, portrait or squarish)
     *
     * @param string $orientation
     * @return Unsplash
     */
    public function orientation(string $orientation)
    {
        if (!in_array($orientation, ['landscape', 'portrait', 'squarish'])) $orientation = '';
        $this->orientation = $orientation;
        return $this->withMeta(['orientation' => $this->orientation]);
    }

    /**
     * Set to true to only display photos that have been featured
     *
     * @param boolean $featured
     * @return Unsplash
     */
    public function featured($featured)
    {
        $this->featured = $featured;
        return $this->withMeta(['featured' => $this->featured]);
    }


    /**
     * Set the size of the image displayed in form and detail view
     * Choose from full, regular, small or thumb
     *
     * @param string $size
     * @return Unsplash
     */
    public function previewSize(string $previewSize)
    {
        if (!in_array($previewSize, ['full', 'regular', 'small', 'thumb'])) $previewSize = 'small';
        $this->previewSize = $previewSize;
        return $this->withMeta(['previewSize' => $this->previewSize]);
    }

}
