<?php
trait Trait_Retryable {
	/**
	 * リトライ処理を行う
	 */
	public function retryable_execute(array $callback, array $args, $retry_count = 6) {
		while(true) {
			try {
				if ($retry_count > 0) {
					$result = call_user_func_array($callback, $args);
					return $result;
				} else {
					\Log::error('Retry count over', __METHOD__);
					throw new \RuntimeException('Retry count over');
				}
			} catch (\GuzzleHttp\Exception\ConnectException $e) {
				\Log::warning("Error code:[{$e->getCode()}] Error message:[{$e->getMessage()}]", __METHOD__);
				sleep(10);
				$retry_count--;
				continue;
			} catch (\GuzzleHttp\Exception\RequestException $e) {
				\Log::warning("Error code:[{$e->getCode()}] Error message:[{$e->getMessage()}]", __METHOD__);
				sleep(20);
				$retry_count--;
				continue;
			}
		}
	}
}
