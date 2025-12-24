<?php

namespace App\Models;

use App\Helpers\Common;
use App\Http\Resources\CenterParameterResource;
use App\Http\Resources\CenterParameterValueResource;
use Dom\Document;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CenterParameter extends Model
{
    public $fillable = ['key', 'name', 'value', 'required', 'type'];

    protected static function booted(): void
    {
        $centerId = Common::centerId();

        static::addGlobalScope('center', function (Builder $builder) use ($centerId) {
            $builder->where('center_id', $centerId);
        });

        //  delete Cache
        $cacheKey = "center_parameters_center_{$centerId}";
        static::saved(fn () => Cache::forget($cacheKey));
        static::deleted(fn () => Cache::forget($cacheKey));
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(CenterParameterValue::class)->where('status', 1);
    }

    public function file(): HasOne
    {
        return $this->hasOne(Document::class, 'id', 'value');
    }

    public function getValue()
    {
        if ($this->type === 'multiselect') {
            return CenterParameterValueResource::collection($this->values);
        }
        if ($this->type === 'boolean') {
            return (bool) $this->value;
        }
        if ($this->type === 'file') {
            return (bool) $this->file;
        }

        return is_numeric($this->value) ? (int) $this->value : $this->value;

    }

    public static function getAll(?Request $request = null): array
    {
        $centerId = Common::centerId();
        $cacheKey = "center_parameters_center_{$centerId}";

        return Cache::rememberForever($cacheKey, function () use ($request) {

            $result = [];
            $groups = self::with('values')->get()->groupBy('group');

            foreach ($groups as $groupName => $items) {
                foreach ($items as $item) {
                    $result[$groupName][$item->key] =
                        (new CenterParameterResource($item))
                            ->resolve($request);
                }
            }

            return $result;
        });
    }

    public function syncMultiselect(array $items): void
    {
        $existing = $this->values->where('updatable', '!=', 0)->keyBy('id');

        $incomingIds = collect($items)
            ->pluck('id')
            ->filter()
            ->toArray();

        // Delete removed values
        $this->values()
            ->whereNotIn('id', $incomingIds)
            ->where('updatable', operator: 1)
            ->update(['status' => 0]);

        foreach ($items as $item) {

            // Update existing
            if (! empty($item['id']) && $existing->has($item['id'])) {
                Log::info($item);

                $existing[$item['id']]->update([
                    'value' => $item['text'],
                ]);

                continue;
            }
            // Insert new
            if (empty($item['id'])) {
                $this->values()->create([
                    'value' => $item['text'],
                ]);
            }

        }
    }
}
