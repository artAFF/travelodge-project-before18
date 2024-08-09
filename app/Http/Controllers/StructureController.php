<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Http\Request;

class StructureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buildings()
    {
        $buildings = Building::orderBy('id')->get();
        return view('structure.buildings', compact('buildings'));
    }

    public function categories()
    {
        $categories = Category::orderBy('id')->get();
        return view('structure.categories', compact('categories'));
    }

    public function departments()
    {
        $departments = Department::orderBy('id')->get();
        return view('structure.departments', compact('departments'));
    }

    public function storeBuilding(Request $request)
    {
        return $this->storeItem($request, Building::class, 'buildings');
    }

    public function storeCategory(Request $request)
    {
        return $this->storeItem($request, Category::class, 'categories');
    }

    public function storeDepartment(Request $request)
    {
        return $this->storeItem($request, Department::class, 'departments');
    }

    private function storeItem(Request $request, $model, $routeName)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string'
        ]);

        $newItem = $request->name;
        $afterItemId = $request->position;

        $items = $model::orderBy('id')->get();

        $insertPosition = $items->where('id', $afterItemId)->first()->id + 1;

        $model::where('id', '>=', $insertPosition)
            ->orderBy('id', 'desc')
            ->increment('id');

        $model::create([
            'id' => $insertPosition,
            'name' => $newItem
        ]);

        $itemName = strtolower(class_basename($model));
        return redirect()->route("structure.{$routeName}")->with('success', ucfirst($itemName) . ' added successfully.');
    }
}
