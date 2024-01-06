<?php

namespace Tests;

trait TestHelper
{

    /**
     * Returns the expected api response in case of error
     *
     * @param  array  $message
     * @param  int  $code
     *
     * @return array
     */
    protected function errorResponse(
      array $message,
      int $code
    ): array {
        return $this->getStandardResponse([], false, $message, $code);
    }

    /**
     * Returns the expected api response in case of error
     *
     * @param  array  $data
     * @param  array  $message
     * @param  int  $code
     *
     * @return array
     */
    public function successResponse(
      array $data = [],
      array $message = [],
      int $code = 200
    ) {
        return $this->getStandardResponse(
          $data,
          true,
          $message,
          $code
        );
    }

    /**
     * Returns the expected api respose
     *
     * @param  array  $data
     * @param  bool  $status
     * @param  array  $message
     * @param  int  $code
     *
     * @return array
     */
    protected function getStandardResponse(
      array $data,
      bool $status,
      array $message,
      int $code
    ): array {
        return [
          "status" => $status,
          "status_code" => $code,
          "message" => $message,
          "body" => $data,
        ];
    }

}
