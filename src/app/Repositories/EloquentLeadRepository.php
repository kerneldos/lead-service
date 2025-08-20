<?php

namespace App\Repositories;

use App\Entities\Lead;
use App\Models\LeadModel;
use App\Repositories\Contracts\LeadRepositoryInterface;

class EloquentLeadRepository implements LeadRepositoryInterface
{
    public function save(Lead $lead): Lead
    {
        if ($lead->getId() !== null) {
            $model = LeadModel::findOrFail($lead->getId());
        } else {
            $model = new LeadModel();
        }

        $model->channel_id = $lead->getChannelId();
        $model->data = $lead->getData();
        $model->is_full = $lead->isFull();
        $model->processed_at = $lead->getProcessedAt();
        $model->save();

        return new Lead(
            $model->id,
            $model->channel_id,
            $model->data,
            $model->is_full,
            $model->processed_at,
            $model->created_at
        );
    }

    public function findById(int $id): ?Lead
    {
        $model = LeadModel::find($id);

        if (!$model) {
            return null;
        }

        return new Lead(
            $model->id,
            $model->channel_id,
            $model->data,
            $model->is_full,
            $model->processed_at,
            $model->created_at
        );
    }
}
