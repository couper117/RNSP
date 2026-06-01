<?php

namespace App\Services;

use App\Models\Player;
use App\Models\PlayerDocument;

class PlayerVerificationService
{
    public function verifyPlayer(Player $player)
    {
        $requiredDocuments = ['birth_certificate', 'passport', 'national_id'];
        foreach ($requiredDocuments as $docType) {
            $document = PlayerDocument::where('player_id', $player->id)->where('document_type', $docType)->first();
            if (!$document || $document->status !== 'approved') {
                return false;
            }
        }
        $player->update(['status' => 'verified']);
        return true;
    }

    public function getDocumentStatus(Player $player)
    {
        $documents = PlayerDocument::where('player_id', $player->id)->get();
        $status = ['birth_certificate' => 'missing', 'passport' => 'missing', 'national_id' => 'missing'];
        foreach ($documents as $doc) {
            $status[$doc->document_type] = $doc->status;
        }
        return $status;
    }

    public function approveDocument(PlayerDocument $document, $userId)
    {
        $document->update(['status' => 'approved', 'reviewed_by' => $userId, 'reviewed_at' => now()]);
        $this->verifyPlayer($document->player);
    }

    public function rejectDocument(PlayerDocument $document, $userId, $reason)
    {
        $document->update(['status' => 'rejected', 'rejection_reason' => $reason, 'reviewed_by' => $userId, 'reviewed_at' => now()]);
        $document->player->update(['status' => 'pending']);
    }
}
