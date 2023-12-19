<?php

namespace taskforce\logic\exception;

use Exception;

// Исключение для проверки статуса 
class StatusException extends Exception {};

//  Исключение для доступных действий 
class AvailableActionsException extends Exception {};