<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu as SiteMenu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\MenuItem;

class MenuController extends Controller
{
    public function index($menu_position){
        $menu = SiteMenu::where('position', $menu_position)->first();
        if(!$menu)
            return response()->json(['error' => 'Oops, something wrong happend.'], 400);

        $menu_items = Cache::get('menu-'.Str::slug($menu_position), function () use($menu) {
            return $this->menu_tree($menu->id, 0);
        });

        return response()->json(['data'=>$menu_items]);
    }

    protected function menu_tree($menu_id, $parent){
        $items = MenuItem::where('menu_id', $menu_id)->where('parent_id', $parent)->orderBy('menu_order', 'ASC')->get();
        $menu_items = [];
        if($items)
        {
            foreach ($items as $key => $item) {
                $menu_items[$key]['title'] = $item->title;
                if($item->menu_type == 'custom_link')
                {
                    if($item->url != '#')
                        $menu_items[$key]['url'] = $item->url;
                    else
                        $menu_items[$key]['url'] = $item->url;
                }
                elseif ($item->menu_type == 'pages_link' && $item->linkable)
                {
                    if($item->linkable)
                        $menu_items[$key]['url'] = url('company', $item->linkable->slug);
                }
                elseif($item->menu_type == 'frontend_pages_link' && $item->linkable)
                {
                    if($item->linkable)
                        $menu_items[$key]['url'] = url(route($item->linkable->slug, [], false));
                }

                if(count($item->children)>0)
                {
                    $menu_items[$key]['children'] = $this->menu_tree($menu_id, $item->id);
                }
            }
        }
        return $menu_items;
    }
}
