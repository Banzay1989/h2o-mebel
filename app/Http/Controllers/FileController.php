<?php namespace App\Http\Controllers;


use App\Order;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller {


  /**
   * @param Order $order
   * @param int $file_id
   * @return BinaryFileResponse|void
   */
  public function order(Order $order, int $file_id) {

    if ($order) {
      $file = $order->getMedia('orders_files')->where('id', $file_id)->first();

      if ($file) {
        $headers = array(
          'Content-Type: ' . $file->mime_type,
        );

        return response()->file($file->getPath(), $headers);
      } else {
        return abort(404, 'File Not Found');
      }
    } else {
      abort(404, 'Task Not Found');
    }
  }

  /**
   * @param int $task_id
   * @return BinaryFileResponse|void
   */
  public function pyramid_acceptance_act(int $task_id) {
    $td = PyramidAcceptanceAct::find($task_id);
    if ($td) {
      $pyramid_acceptance_act_file = $td->getMedia('pyramid_acceptance_act')->first();
      if ($pyramid_acceptance_act_file) {
        $headers = array(
          'Content-Type: ' . $pyramid_acceptance_act_file->mime_type,
        );
        return response()->file($pyramid_acceptance_act_file->getPath(), $headers);
      } else {
        return abort(404, 'File Not Found');
      }
    } else {
      abort(404, 'Task Not Found');
    }
  }

  /**
   * @param int $cp_id
   * @param int $file_id
   * @return BinaryFileResponse|void
   */
  public function reconciliation(int $cp_id, int $file_id) {
    $td = Counterparty::find($cp_id);
    if ($td) {
      $reconciliation_file = $td->getMedia('reconciliation')->where('id', $file_id)->first();
      if ($reconciliation_file) {
        $headers = array(
          'Content-Type: ' . $reconciliation_file->mime_type,
        );
        return response()->file($reconciliation_file->getPath(), $headers);
      } else {
        return abort(404, 'File Not Found');
      }
    } else {
      abort(404, 'Task Not Found');
    }
  }

  /**
   * @param int $task_id
   * @param int $file_id
   * @return BinaryFileResponse|void
   */
  public function box_task(int $task_id, int $file_id) {
    $td = ProductionTask::where('id', $task_id)->first();

    if ($td) {
      $box_task_file = $td->getMedia('box_task')->where('id', $file_id)->first();

      if ($box_task_file) {
        $headers = array(
          'Content-Type: ' . $box_task_file->mime_type,
        );

        return response()->file($box_task_file->getPath(), $headers);
      } else {
        return abort(404, 'File Not Found');
      }
    } else {
      abort(404, 'Task Not Found');
    }
  }

  /**
   * @param int $file_id
   */
  public function deleteFile(int $file_id): void {
    Media::whereHas('media', static function ($query) use ($file_id) {
      $query->whereId($file_id);
    })->first()->deleteMedia($file_id);
  }

}
