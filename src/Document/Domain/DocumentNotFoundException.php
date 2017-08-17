<?php

namespace Document\Domain;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class DocumentNotFoundException extends NotFoundHttpException
{
}
