<?php
/**
 * FeedbackAction Listing Column for UI Component
 *
 * @package Tasks\Feedback\Ui\Component\Listing\Columns
 */
namespace Tasks\Feedback\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

/**
 * FeedbackAction Column Class
 *
 * @api
 * @since 100.0.2
 */
class FeedbackAction extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $storeId = $this->context->getFilterParam('store_id');

            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = [
                    'View' => [
                        'href' => $this->urlBuilder->getUrl(
                            'adminfeedback/action/view',
                            ['id' => $item['id'], 'email' => $item['email'], 'store' => $storeId]
                        ),
                        'label' => __('View')
                    ],
                ];
            }
        }

        return $dataSource;
    }
}
