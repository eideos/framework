<?php

namespace Eideos\Framework\Lib;

use Illuminate\Support\Facades\Route;

class AbstractMenu
{
    protected $menu = [
        "sections" => [
            [
                "header" => "",
                "items" => [
                    "inicio" => [
                        "label" => "Inicio",
                        "icon" => "home",
                        "url" => "/"
                    ],
                    "admin" => [
                        "label" => "Administración",
                        "icon" => "cog",
                        "items" => [
                            "users" => [
                                "label" => "Usuarios",
                                "controller" => "Eideos\Framework\Controllers\UserController",
                                "action" => "index",
                                "active_actions" => ["create", "edit", "show"],
                            ],
                            "roles" => [
                                "label" => "Roles",
                                "controller" => "Eideos\Framework\Controllers\RoleController",
                                "action" => "index",
                                "active_actions" => ["create", "edit", "show"],
                            ],
                            "rights" => [
                                "label" => "Derechos",
                                "controller" => "Eideos\Framework\Controllers\RightController",
                                "action" => "index",
                                "active_actions" => ["create", "edit", "show"],
                            ],
                            "buttons" => [
                                "label" => "Botones",
                                "controller" => "Eideos\Framework\Controllers\ButtonController",
                                "action" => "index",
                                "active_actions" => ["create", "edit", "show"],
                            ],
                            "blocks" => [
                                "label" => "Bloqueos",
                                "controller" => "Eideos\Framework\Controllers\BlockController",
                                "action" => "index",
                                "active_actions" => ["show"],
                            ],
                            "audits" => [
                                "label" => "Auditoría",
                                "controller" => "Eideos\Framework\Controllers\AuditController",
                                "action" => "index",
                                "active_actions" => ["show"],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ];
    protected $data;
    protected $url;
    protected $routeAction;
    protected $routeUrl;

    public function __construct($url = null)
    {
        $this->url = $url;
        $this->data = $this->get_menu();
        $this->routeAction = explode("@", Route::getCurrentRoute()->getActionName());
        $this->routeUrl =  Route::getCurrentRoute()->uri;
    }

    protected function get_menu()
    {
        if (!isset($this->menu['sections'])) {
            return [
                "sections" => [
                    ["header" => "", "items" => $this->menu]
                ],
            ];
        }
        return $this->menu;
    }

    public function getUrl($menuItem)
    {
        $url = url("/");
        if (isset($menuItem["url"])) {
            $url = $menuItem["url"];
        }
        if (isset($menuItem["controller"]) && isset($menuItem["action"])) {
            $url = fmw_action($menuItem["controller"], $menuItem["action"]);
        }
        return $url;
    }

    public function renderMenu($menu = [], $menuLabelParent = "menu", $num = 1)
    {
        if (empty($menu)) {
            $menu = $this->data;
        }
        $html = '';
        foreach ($menu["sections"] as $key => $menuSection) {
            $html .= $this->renderSection($menuSection);
        }
        $html .= '';
        return $html;
    }

    public function renderSection($menuSection, $divider = true)
    {
        $html = '';
        if (!$this->isAuthorizedSection($menuSection)) {
            return $html;
        }
        if (!empty($menuSection['header'])) {
            $html .= '<div class="sidebar-heading">' . $menuSection['header'] . '</div>';
        }
        foreach ($menuSection["items"] as $menuId => $menuItem) {
            $html .= $this->RenderItem($menuItem, $menuId);
        }
        $html .= '<hr class="sidebar-divider middle-divider">';
        return $html;
    }

    public function RenderItem($menuItem, $menuId)
    {
        $html = "";
        if (isset($menuItem["items"])) {
            if (!$this->isAuthorizedMenu($menuItem)) {
                return $html;
            }
        } else {
            if (!$this->isAuthorizedItem($menuItem)) {
                return $html;
            }
        }

        $active = $this->isActiveItem($menuItem);
        $html .= '<li class="nav-item ' . ($active ? 'active' : '') . (!empty($menuItem["class"]) ? ' ' . $menuItem["class"] : '') . '">';
        $html .= '<a class="nav-link ' . ($active ? '' : 'collapsed') . '"';
        if (isset($menuItem["items"])) {
            $html .= ' href="#" data-toggle="collapse" data-target="#' . $menuId . '" ' . ($active ? 'aria-expanded="true"' : '') . ' aria-controls="' . $menuId . '">';
        } else {
            $html .= ' href="' . $this->getUrl($menuItem) . '">';
        }
        if (isset($menuItem["icon"])) {
            if (strstr($menuItem["icon"], ".svg")) {
                $html .= '<img src="' . asset('img/icons/' . $menuItem["icon"]) . '" /></i>';
            } else {
                $html .= '<i class="fa fa-fw fa-' . $menuItem["icon"] . '"></i>';
            }
        }
        if (isset($menuItem["label"])) {
            $html .= '<span>' . $menuItem["label"] . '</span>';
        }
        if (isset($menuItem["counts"]) && !empty($menuItem["counts"])) {
            foreach ($menuItem["counts"] as $color => $count) {
                if (isset($count['callback']) && function_exists($count['callback'])) {
                    $cant = call_user_func($count['callback']);
                    if ($cant == 0) {
                        if ((isset($count['show_blank']) && $count['show_blank']) || !isset($count['show_blank'])) {
                            $html .= '&nbsp;<span class="badge badge-pill badge-' . $color . '" data-toggle="tooltip" title="' . (isset($count['label']) ? $count['label'] : $cant) . '">' . $cant . '</span>';
                        }
                    } else {
                        $html .= '&nbsp;<span class="badge badge-pill badge-' . $color . '" data-toggle="tooltip" title="' . (isset($count['label']) ? $count['label'] : $cant) . '">' . $cant . '</span>';
                    }
                }
            }
        }
        $html .= '</a>';
        if (isset($menuItem["items"])) {
            $html .= $this->RenderSubMenu($menuItem["items"], $menuId, $active);
        }
        $html .= '</li>';
        return $html;
    }

    public function RenderSubMenu($menuItems, $parentMenuId, $active)
    {
        $html = "";
        $html .= '<div id="' . $parentMenuId . '" class="collapse ' . ($active ? 'show' : '') . '" aria-labelledby="heading' . $parentMenuId . '" data-parent="#accordionSidebar">';
        $html .= '<div class="bg-white py-2 collapse-inner rounded">';
        foreach ($menuItems as $menuItem) {
            if (!$this->isAuthorizedItem($menuItem)) {
                continue;
            }
            if (!empty($menuItem['header'])) {
                $html .= '<h6 class="collapse-header">' . $menuItem['header'] . '</h6>';
            }
            $html .= '<a class="collapse-item ' . ($this->isActiveItem($menuItem) ? 'active' : '') . '" href="' . $this->getUrl($menuItem) . '">' . $menuItem['label'] . '</a>';
        }
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    protected function isAuthorizedSection($menuSection)
    {
        foreach ($menuSection['items'] as $menuItem) {
            if (isset($menuItem["items"])) {
                if ($this->isAuthorizedMenu($menuItem)) {
                    return true;
                }
            } else {
                if ($this->isAuthorizedItem($menuItem)) {
                    return true;
                }
            }
        }
        return false;
    }

    protected function isAuthorizedMenu($menu)
    {
        $authorizedItems = false;
        $authorizedMenus = false;
        foreach ($menu["items"] as $menuItem) {
            if (isset($menuItem["items"])) {
                $authorizedMenus = $authorizedMenus || $this->isAuthorizedMenu($menuItem);
            } else {
                $authorizedItems = $authorizedItems || $this->isAuthorizedItem($menuItem);
            }
        }
        return $authorizedMenus || $authorizedItems;
    }

    protected function isAuthorizedItem($item)
    {
        if (isset($item["controller"]) && isset($item["action"])) {
            if (is_authorized($item["controller"], $item["action"])&& (!isset($item["displayFunction"]) || !function_exists($item["displayFunction"]) || $item["displayFunction"]($item))) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

    protected function isActiveMenu($menu)
    {
        foreach ($menu as $menuItem) {
            if ($this->isActiveItem($menuItem)) {
                return true;
            }
        }
        return false;
    }

    protected function isActiveItem($menuItem)
    {
        if (isset($menuItem["items"])) {
            foreach ($menuItem["items"] as $childItem) {
                if ($this->isActiveItem($childItem)) {
                    return true;
                }
            }
        }
        if (!empty($menuItem["url"]) && !empty($this->routeUrl) && (substr($this->routeUrl, 0, 1) == "/" ? "" : "/") . $this->routeUrl == $menuItem["url"]) {
            return true;
        } elseif (!empty($menuItem["controller"]) && !empty($menuItem["action"]) && !empty($this->routeAction) && count($this->routeAction) == 2 && $this->routeAction[0] == $menuItem["controller"] && in_array($this->routeAction[1], array_merge([$menuItem["action"]], $menuItem["active_actions"] ?? []))) {
            return true;
        }
        return false;
    }
}
