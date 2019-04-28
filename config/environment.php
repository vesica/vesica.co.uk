<?php
// The below should always return development, staging, or production
$provisionContext = strtolower(getenv('PROVISION_CONTEXT'));
if (!in_array($provisionContext, ['development', 'staging', 'production'])) {
    $provisionContext = 'development';
}
