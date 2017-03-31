<?php

use WindowsAzure\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Common\ServiceException;
use MicrosoftAzure\Storage\Table\Models\QueryEntitiesOptions;
use MicrosoftAzure\Storage\Table\Models\EdmType;
use MicrosoftAzure\Storage\Table\Models\Filters\Filter;

/**
 * Class Model_Sensordaily
 */
class Model_Sensordaily extends Model_Base_Storage_Table
{
	use Trait_Time_Average_Calculatable;

	/** Azure Storage Table 上のテーブル名 **/
	protected static $_table_name = 'sensordaily';
}
