<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use Illuminate\Http\Request;
use App\Models\Menu as SiteMenu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\MenuItem;
use App\Models\FrontendPage;
use App\Models\Package;
use App\Models\Rental;

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
                        $menu_items[$key]['url'] = $item->linkable->slug;
                }
                elseif($item->menu_type == 'frontend_pages_link' && $item->linkable)
                {
                    if($item->linkable)
                        $menu_items[$key]['url'] = $item->linkable->slug;
                }

                if(count($item->children)>0)
                {
                    $menu_items[$key]['children'] = $this->menu_tree($menu_id, $item->id);
                }
            }
        }
        return $menu_items;
    }

    public function header(){
        $pages = FrontendPage::whereIn('slug', ['accommodations', 'rentals', 'packages'])->get();
        $menu = [];
        $key = 0;
        foreach($pages as $page){
            $menu['menu'][$key]['title'] = $page->title;
            $menu['menu'][$key]['type'] = $page->slug;
            if($page->menu_icon){
                $menu['menu'][$key]['icon'] = [
                    "file_name" => $page->menu_icon->file_name,
                    "file_path" => asset($page->menu_icon->file_path)
                ];
            }
            else
                $menu['menu'][$key]['icon'] = [];
            
            if($page->menu_bg_image){
                $menu['menu'][$key]['bg_image'] = [
                    "file_name" => $page->menu_bg_image->file_name,
                    "file_path" => asset($page->menu_bg_image->file_path)
                ];
            }
            else
                $menu['menu'][$key]['bg_image'] = [];

            $menu['menu'][$key]['children'] = $this->getServicesMenu($page->slug);
            $key++;
        }

        $menu_position = "Main Menu";
        $site_menu = SiteMenu::where('position', $menu_position)->first();
        if(!$site_menu)
            return response()->json(['error' => 'Oops, something wrong happend.'], 400);

        $menu_items = Cache::get('menu-'.Str::slug($menu_position), function () use($site_menu) {
            return $this->menu_tree($site_menu->id, 0);
        });

        $menu['menu'][$key] = array_shift($menu_items);
        $menu['meta_data'] = $this->getSettings();

        return response()->json(['data'=>$menu]);
    }

    protected function getServicesMenu($type){
        $data = [];
        if($type == 'accommodations')
            $data = Accommodation::select('title', \DB::raw('CONCAT("accommodations/", slug) as slug'))->where('status', 1)->where('show_on_menu', 1)->orderBy('priority')->get()->toArray();

        if($type == 'rentals')
            $data = Rental::select('title', \DB::raw('CONCAT("rentals/", slug) as slug'))->where('status', 1)->where('show_on_menu', 1)->orderBy('priority')->get()->toArray();

        if($type == 'packages')
            $data = Package::select('title', \DB::raw('CONCAT("packages/", slug) as slug'))->where('status', 1)->where('show_on_menu', 1)->orderBy('priority')->get()->toArray();

        return $data;
    }
}
