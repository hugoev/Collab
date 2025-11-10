<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

Broadcast::channel('document.{documentId}', function ($user, $documentId) {
    $document = \App\Models\Document::find($documentId);
    return $document && $document->user_id === $user->id;
});

