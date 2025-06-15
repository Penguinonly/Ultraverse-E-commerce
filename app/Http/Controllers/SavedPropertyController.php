<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\SavedProperty;
use Illuminate\Support\Facades\Auth;

class SavedPropertyController extends Controller
{
    public function index()
    {
        $savedProperties = SavedProperty::with(['property.images', 'property.user'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('Home.simpan', compact('savedProperties'));
    }

    public function store(Request $request, $propertyId)
    {
        try {
            $property = Property::findOrFail($propertyId);
            
            // Check if already saved
            $existingSave = SavedProperty::where('user_id', Auth::id())
                ->where('property_id', $propertyId)
                ->first();

            if ($existingSave) {
                return response()->json([
                    'message' => 'Property already saved'
                ], 400);
            }

            // Create new saved property
            $savedProperty = new SavedProperty([
                'user_id' => Auth::id(),
                'property_id' => $propertyId
            ]);
            $savedProperty->save();

            return response()->json([
                'message' => 'Property saved successfully',
                'data' => $savedProperty
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error saving property',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($propertyId)
    {
        try {
            $savedProperty = SavedProperty::where('user_id', Auth::id())
                ->where('property_id', $propertyId)
                ->firstOrFail();

            $savedProperty->delete();

            return response()->json([
                'message' => 'Property removed from saved list'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error removing property',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function check($propertyId)
    {
        $isSaved = SavedProperty::where('user_id', Auth::id())
            ->where('property_id', $propertyId)
            ->exists();

        return response()->json([
            'is_saved' => $isSaved
        ]);
    }

    public function toggle(Request $request, $propertyId)
    {
        try {
            $savedProperty = SavedProperty::where('user_id', Auth::id())
                ->where('property_id', $propertyId)
                ->first();

            if ($savedProperty) {
                $savedProperty->delete();
                $message = 'Property removed from saved list';
                $isSaved = false;
            } else {
                SavedProperty::create([
                    'user_id' => Auth::id(),
                    'property_id' => $propertyId
                ]);
                $message = 'Property saved successfully';
                $isSaved = true;
            }

            return response()->json([
                'message' => $message,
                'is_saved' => $isSaved
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error toggling property save status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
