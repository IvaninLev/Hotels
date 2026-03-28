<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Reviews;

use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reviews;
use App\MoonShine\Resources\Reviews\Pages\ReviewsIndexPage;
use App\MoonShine\Resources\Reviews\Pages\ReviewsFormPage;
use App\MoonShine\Resources\Reviews\Pages\ReviewsDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Reviews, ReviewsIndexPage, ReviewsFormPage, ReviewsDetailPage>
 */
class ReviewsResource extends ModelResource
{
    protected string $model = Review::class;

    protected string $title = 'Reviews';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ReviewsIndexPage::class,
            ReviewsFormPage::class,
            ReviewsDetailPage::class,
        ];
    }
}
