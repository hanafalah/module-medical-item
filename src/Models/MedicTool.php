<?php

namespace Hanafalah\ModuleMedicalItem\Models;

use Hanafalah\ModuleMedicalItem\Concerns\HasMedicalItem;
use Hanafalah\ModuleMedicalItem\Enums\Medical\Status;
use Hanafalah\ModuleMedicalItem\Resources\MedicTool\{
    ViewMedicTool,
    ShowMedicTool
};
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;

class MedicTool extends BaseModel
{
    use SoftDeletes, HasProps, HasMedicalItem;

    protected $list = ["id", "name", "status", "props"];
    protected $show = [];

    protected $casts = [
        'name' => 'string'
    ];

    protected static function booted(): void
    {
        parent::booted();
        static::creating(function ($query) {
            if (!isset($query->medictool_code)) {
                $query->medictool_code = static::hasEncoding('MEDICTOOL_CODE');
            }
            if (!isset($query->status)) $query->status = Status::ACTIVE->value;
        });
    }

    public function toViewApi()
    {
        return new ViewMedicTool($this);
    }

    public function toShowApi()
    {
        return new ShowMedicTool($this);
    }
}
