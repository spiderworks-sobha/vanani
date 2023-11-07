<?php

namespace App\Traits;

trait FileUpload {

  protected function fileUpload($file, $path):string
  {
      $filenameWithExt = $file->getClientOriginalName();
      $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
      $extension = $file->getClientOriginalExtension();
      $fileNameToStore = $filename.'_'.time().'.'.$extension;
      $path = $file->storeAs($path, $fileNameToStore, ['disk' => 'public']);
      return 'uploads/'.$path;
  }

}