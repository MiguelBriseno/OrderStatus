<?php
namespace Mavi\OrderStatus\Api\Data;

interface OrderStatusInterface
{
    /**
     * Retrieve the status of an order by its ID.
     *
     * @param string $orderId The ID of the order to retrieve status for.
     * @return string The status of the order.
     * @throws \InvalidArgumentException If the provided order ID is invalid.
     * @throws \Magento\Framework\Exception\NoSuchEntityException If no order is found for the provided ID.
     * @throws \Magento\Framework\Exception\LocalizedException If any other error occurs while retrieving the order status.
     */
    public function getOrderStatus(string $orderId): string;
}
