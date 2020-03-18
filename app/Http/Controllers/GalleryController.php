<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Winery;

class GalleryController extends Controller {

    public function getImage($wineryId, $id) {
        $winery = Winery::find($wineryId);

        if ( !$winery )
            return response()->json(['error' => 'Winery does not exist'], 404);

        // if ( !$winery->galleryHas($image) )
        //     return response()->json(['error' => 'Image does not exist'], 404);

        return response()->download( $winery->galleryImage($id) );
    }

    public function getGallery($wineryId) {
        $winery = Winery::find($wineryId);

        if ( !$winery )
            return response()->json(['error' => 'Winery does not exist'], 404);

        return $winery->gallery;
    }

    public function addImage(Request $r, $wineryId) {
    	if ( !$r->has('file') )
    		return response()->json(['Image not provided'], 400);

        $winery = Winery::find($wineryId);

        if ( !$winery )
        	return response()->json(['error' => 'Winery does not exist'], 404);

        foreach ( $r->file as $file )
            $winery->addImageToGallery($file);

        return response(null, 204);
    }

    public function removeFileFromGallery($wineryId, $id) {
        $winery = Winery::find($wineryId);

        if ( !$winery )
            return response()->json(['error' => 'Winery does not exist'], 404);

        $winery->removeFileFromGallery($id);

        return response(null, 204);
    }

    public function repositionFileInGallery($wineryId, $fileId, $newPosition) {
        $winery = Winery::find($wineryId);

        if (!$winery)
            return response()->json(['error' => 'Winery not found'], 404);

        if ( $newPosition >= $winery->fileAvailablePosition() )
            return response()->json(['error' => 'Invalid request'], 422);

        $file = $winery->gallery()->where('id', $fileId)->first();

        if (!$file)
            return response()->json(['error' => 'File not found'], 404);

        if ( $file->reposition($newPosition) )
            return response(null, 204);

        return response()->json(['error' => 'Something went wrong'], 500);
    }



}
