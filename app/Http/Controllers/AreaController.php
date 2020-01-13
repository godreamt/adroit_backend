<?php

namespace App\Http\Controllers;

use App\Area;
use App\State;
use App\Region;
use App\Country;
use Illuminate\Http\Request;
use App\Http\Requests\AreaRequest;
use App\Http\Requests\StateRequest;
use App\Http\Requests\RegionRequest;
use App\Http\Requests\CountryRequest;
use App\Http\Requests\AreaManagerRequest;

class AreaController extends Controller
{
    public function updateCountry(CountryRequest $request) {
        if(empty($request->id)) {
            $country = new Country();
        }else {
            $country = Country::find($request->id);
        }

        $country->country = $request->title;

        try{
            $country->save();
            return response(["Country saved successfully"]);
        }catch(\Exception $e) {
            return response(["Can not save country"], 400);
        }
    }

    public function getCountries(Request $request) {
        $country =  Country::select('countries.*');

        if(!empty($request->searchText)) {
            $country = $country->where('country', 'LIKE', '%'.$request->searchText.'%');
        }

        return $country->get();
    }

    public function deleteCountry(Request $request, $id) {
        try {
            $country = Country::find($id);
            $country->delete();
            return response(["Country deleted successfully"]);
        }catch(\Exception $e) {
            return response(["Can not delete country"], 400);
        }
    }

    
    public function updateState(StateRequest $request) {
        if(empty($request->id)) {
            $state = new State();
        }else {
            $state = State::find($request->id);
        }

        $state->state = $request->title;
        $state->country_id = $request->country_id;

        try{
            $state->save();
            return response(["State saved successfully"]);
        }catch(\Exception $e) {
            return response(["Can not save state"], 400);
        }
    }

    public function getStates(Request $request) {
        $states = State::leftJoin('countries', 'countries.id', 'states.country_id')
                        ->select('states.*', 'countries.country');
        
        if(!empty($request->searchText)) {
            $states = $states->where('state', 'LIKE', '%'.$request->searchText.'%');
        }

        if(!empty($request->country_id)) {
            $states = $states->where('country_id', $request->country_id);
        }

        return $states->get();
    }

    public function deleteState(Request $request, $id) {
        try {
            $state = State::find($id);
            $state->delete();
            return response(["State deleted successfully"]);
        }catch(\Exception $e) {
            return response(["Can not delete state"], 400);
        }
    }

    
    public function updateRegion(RegionRequest $request) {
        if(empty($request->id)) {
            $region = new Region();
        }else {
            $region = Region::find($request->id);
        }

        $region->region = $request->title;
        $region->state_id = $request->state_id;

        try{
            $region->save();
            return response(["Region saved successfully"]);
        }catch(\Exception $e) {
            return response(["Can not save region"], 400);
        }
    }

    public function getRegions(Request $request) {
        $regions = Region::leftJoin('states', 'states.id', 'regions.state_id')
                        ->leftJoin('countries', 'countries.id', 'states.country_id')
                        ->select('regions.*', 'countries.id as country_id', 'countries.country', 'states.state');
        
        if(!empty($request->searchText)) {
            $regions = $regions->where('region', 'LIKE', '%'.$request->searchText.'%');
        }

        if(!empty($request->country_id)) {
            $regions = $regions->where('country_id', $request->country_id);
        }

        if(!empty($request->state_id)) {
            $regions = $regions->where('state_id', $request->state_id);
        }

        return $regions->get();
    }

    public function deleteRegion(Request $request, $id) {
        try {
            $region = Region::find($id);
            $region->delete();
            return response(["Region deleted successfully"]);
        }catch(\Exception $e) {
            return response(["Can not delete region"], 400);
        }
    }

    
    public function updateArea(AreaRequest $request) {
        if(empty($request->id)) {
            $area = new Area();
        }else {
            $area = Area::find($request->id);
        }

        $area->area = $request->title;
        $area->region_id = $request->region_id;

        try{
            $area->save();
            return response(["Area saved successfully"]);
        }catch(\Exception $e) {
            return response(["Can not save area"], 400);
        }
    }

    public function getAreas(Request $request) {
        $areas = Area::leftJoin('regions', 'regions.id', 'areas.region_id')
                        ->leftJoin('states', 'states.id', 'regions.state_id')
                        ->leftJoin('countries', 'countries.id', 'states.country_id')
                        ->select('areas.*', 'countries.country', 'countries.id as country_id', 'states.state', 'states.id as state_id', 'regions.region');
        
        
        if(!empty($request->searchText)) {
            $areas = $areas->where('area', 'LIKE', '%'.$request->searchText.'%');
        }

        if(!empty($request->country_id)) {
            $areas = $areas->where('country_id', $request->country_id);
        }

        if(!empty($request->state_id)) {
            $areas = $areas->where('state_id', $request->state_id);
        }
        
        if(!empty($request->region_id)) {
            $areas = $areas->where('region_id', $request->region_id);
        }

        return $areas->get();
    }

    public function deleteArea(Request $request, $id) {
        try {
            $area = Area::find($id);
            $area->delete();
            return response(["Area deleted successfully"]);
        }catch(\Exception $e) {
            return response(["Can not delete area"], 400);
        }
    }
}
