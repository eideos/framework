<?php

namespace Eideos\Framework;

use Illuminate\Database\Eloquent\Model;

class Block extends Model {

    protected $fillable = ['created_by', 'updated_by', 'session_id', 'user_id', 'model', 'model_id'];

    public function user() {
        return $this->belongsTo('Eideos\Framework\User');
    }

    public static function checkAndBlockModelId($model, $modelId) {
        if (empty($model) || empty($modelId)) {
            return false;
        }
        $blocker = self::checkBlock($model, $modelId);
        if (!empty($blocker)) {
            if ($blocker->session_id != session()->getId()) {
                return $blocker->user->fullname;
            } else {
                return false;
            }
        }
        $block = new Block();
        $block->session_id = session()->getId();
        $block->user_id = \Auth::user()->id;
        $block->model = $model;
        $block->model_id = $modelId;
        $block->save();
        return false;
    }

    public static function freeBlock($model, $modelId) {
        if (empty($model) || empty($modelId)) {
            return false;
        }
        return self::where('model', $model)->where('model_id', $modelId)->delete();
    }

    public static function freeBlockByUser($userId = null) {
        if (empty($userId)) {
            return false;
        }
        return self::where('user_id', $userId)->delete();
    }

    protected static function checkBlock($model, $modelId) {
        if (empty($model) || empty($modelId)) {
            return false;
        }
        self::deleteExpiredBlocks();

        $block = self::where('model', $model)->where('model_id', $modelId)->first();
        if (empty($block)) {
            return false;
        }
        return $block;
    }

    protected static function deleteExpiredBlocks() {
        return self::where('created_at', '<', date("Y-m-d H:i:s", strtotime("-15 minutes")))->delete();
    }

}
