<?php

declare(strict_types=1);

namespace App\View\Design\Components\Widget\ProductToolbar;

use App\Models\Feature;
use App\Support\Filters\FilterInput;
use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Override;

class FeatureFilter extends Component
{
    /**
     * @var Collection<int,Feature>
     */
    public Collection $features;

    /**
     * @var array<string,array<int, string>>
     */
    public array $featuresInput = [];

    /**
     * Create a new component instance.
     *
     * @throws Exception
     */
    public function __construct(string $categoryId)
    {
        $this->featuresInput = request()->array('features') |> FilterInput::featureMap(...);

        $this->features = Feature::repository()
            ->featureFilterOptionsForCategory($categoryId);
    }

    #[Override]
    public function shouldRender(): bool
    {
        return $this->features->isNotEmpty();
    }

    public function active(string $featureId): bool
    {
        return isset($this->featuresInput[$featureId]);
    }

    public function activeOption(string $featureId, string $value): bool
    {
        $requestOptions = $this->featuresInput[$featureId] ?? null;

        return $requestOptions && in_array($value, $requestOptions);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('design.components.widget.product-toolbar.feature-filter');
    }
}
