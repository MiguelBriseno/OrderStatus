<?php
namespace Mavi\OrderStatus\Api;

interface OrderStatusInterface
{
    /**
     * Retrieve the status of an order by its ID
     *
     * @param string $orderId The increment ID of the order
     * @return string The status of the order
     * @throws \InvalidArgumentException If the $orderId is not valid
     * @throws \Magento\Framework\Exception\NoSuchEntityException If the order does not exist
     * @throws \Magento\Framework\Exception\LocalizedException If another error occurs
     */
    public function getOrderStatus(string $orderId): string;
}
