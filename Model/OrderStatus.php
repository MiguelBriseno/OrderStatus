<?php
namespace Mavi\OrderStatus\Model;

use Mavi\OrderStatus\Api\OrderStatusInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Psr\Log\LoggerInterface;

class OrderStatus implements OrderStatusInterface
{
    const ERROR_MESSAGE = 'Order not found';
    const INVALID_ORDER_ID_MESSAGE = 'Invalid order ID';

    protected $orderRepository;
    protected $searchCriteriaBuilder;
    protected $filterBuilder;
    protected $logger;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        LoggerInterface $logger
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->logger = $logger;
    }

    public function getOrderStatus(string $orderId): string
    {
        // Validar si el parámetro orderId es válido (positivo)
        if ($orderId <= 0) {
            $this->logger->error(sprintf('Invalid order ID provided: %s', $orderId));
            return self::INVALID_ORDER_ID_MESSAGE;
        }

        try {
            // Crear filtro para buscar por increment_id
            $filter = $this->filterBuilder
                ->setField('increment_id')
                ->setValue($orderId)
                ->setConditionType('eq')
                ->create();

            // Construir criterio de búsqueda
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilters([$filter])
                ->create();

            // Obtener órdenes coincidentes
            $orders = $this->orderRepository->getList($searchCriteria)->getItems();

            // Verificar si se encontraron órdenes
            if (!empty($orders)) {
                $order = reset($orders); // Obtener el primer pedido de la lista
                return $order->getStatus(); // Devolver el estado de la orden
            }

            return self::ERROR_MESSAGE;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Error retrieving order (ID: %s): %s', $orderId, $e->getMessage()));
            return self::ERROR_MESSAGE . ': ' . $e->getMessage();
        }
    }
}
