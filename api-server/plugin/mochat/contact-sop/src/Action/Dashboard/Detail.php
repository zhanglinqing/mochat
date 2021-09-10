<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\Plugin\ContactSop\Action\Dashboard;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use MoChat\App\Common\Middleware\DashboardAuthMiddleware;
use MoChat\App\Rbac\Middleware\PermissionMiddleware;
use MoChat\Framework\Action\AbstractAction;
use MoChat\Plugin\ContactSop\Logic\DetailLogic;

/**
 * 查询 - 列表.
 * @Controller
 */
class Detail extends AbstractAction
{
    /**
     * @var DetailLogic
     */
    protected $detailLogic;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    public function __construct(DetailLogic $detailLogic, RequestInterface $request)
    {
        $this->detailLogic = $detailLogic;
        $this->request = $request;
    }

    /**
     * 规则详情.
     * @Middlewares({
     *     @Middleware(DashboardAuthMiddleware::class),
     *     @Middleware(PermissionMiddleware::class)
     * })
     * @RequestMapping(path="/dashboard/contactSop/detail", methods="GET")
     */
    public function handle(): array
    {
        $params['id'] = $this->request->input('id'); //规则id

        $user = user();
        $params['corpId'] = $user['corpIds'][0];

        return $this->detailLogic->handle($params);
    }
}
