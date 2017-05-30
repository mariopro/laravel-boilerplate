<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;

class MetaTags
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeName = $request->route()->getName();

        $metaTitle = Lang::has("metas.$routeName.title", null, false)
            ? trans("metas.$routeName.title")
            : trans('metas.default.title');
        $metaDescription = Lang::has("metas.$routeName.description", null, false)
            ? trans("metas.$routeName.description")
            : trans('metas.default.description');

        View::composer('*', function(\Illuminate\View\View $view) use($metaTitle) {
            $view->with('title', $metaTitle);
        });

        View::composer('*', function(\Illuminate\View\View $view) use($metaDescription) {
            $view->with('description', $metaDescription);
        });

        return $next($request);
    }
}
