<?php declare(strict_types=1);

namespace Shopware\Storefront\Controller;

use Shopware\Core\Checkout\Customer\CustomerEntity;
use Shopware\Core\Checkout\Customer\Exception\CustomerWishlistNotFoundException;
use Shopware\Core\Checkout\Customer\Exception\DuplicateWishlistProductException;
use Shopware\Core\Checkout\Customer\SalesChannel\AbstractAddWishlistProductRoute;
use Shopware\Core\Checkout\Customer\SalesChannel\AbstractLoadWishlistRoute;
use Shopware\Core\Checkout\Customer\SalesChannel\AbstractMergeWishlistProductRoute;
use Shopware\Core\Checkout\Customer\SalesChannel\AbstractRemoveWishlistProductRoute;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Feature;
use Shopware\Core\Framework\Routing\Annotation\LoginRequired;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\Routing\Annotation\Since;
use Shopware\Core\Framework\Routing\Exception\MissingRequestParameterException;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\Wishlist\WishlistGuestPageLoader;
use Shopware\Storefront\Page\Wishlist\WishlistPageLoader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"storefront"})
 */
class WishlistController extends StorefrontController
{
    /**
     * @var WishlistPageLoader
     */
    private $wishlistPageLoader;

    /**
     * @var AbstractLoadWishlistRoute
     */
    private $wishlistLoadRoute;

    /**
     * @var AbstractAddWishlistProductRoute
     */
    private $addWishlistRoute;

    /**
     * @var AbstractRemoveWishlistProductRoute
     */
    private $removeWishlistProductRoute;

    /**
     * @var AbstractMergeWishlistProductRoute
     */
    private $mergeWishlistProductRoute;

    /**
     * @var WishlistGuestPageLoader
     */
    private $guestPageLoader;

    public function __construct(
        WishlistPageLoader $wishlistPageLoader,
        AbstractLoadWishlistRoute $wishlistLoadRoute,
        AbstractAddWishlistProductRoute $addWishlistRoute,
        AbstractRemoveWishlistProductRoute $removeWishlistProductRoute,
        AbstractMergeWishlistProductRoute $mergeWishlistProductRoute,
        WishlistGuestPageLoader $guestPageLoader
    ) {
        $this->wishlistPageLoader = $wishlistPageLoader;
        $this->wishlistLoadRoute = $wishlistLoadRoute;
        $this->addWishlistRoute = $addWishlistRoute;
        $this->removeWishlistProductRoute = $removeWishlistProductRoute;
        $this->mergeWishlistProductRoute = $mergeWishlistProductRoute;
        $this->guestPageLoader = $guestPageLoader;
    }

    /**
     * @Since("6.3.4.0")
     * @Route("/wishlist", name="frontend.wishlist.page", options={"seo"="false"}, methods={"GET"})
     */
    public function index(Request $request, SalesChannelContext $context): Response
    {
        if ($context->getCustomer()) {
            $page = $this->wishlistPageLoader->load($request, $context);
        } else {
            $page = $this->guestPageLoader->load($request, $context);
        }

        return $this->renderStorefront('@Storefront/storefront/page/wishlist/index.html.twig', ['page' => $page]);
    }

    /**
     * @Since("6.3.5.0")
     * @Route("/wishlist/guest-pagelet", name="frontend.wishlist.guestPage.pagelet", options={"seo"="false"}, methods={"POST"}, defaults={"XmlHttpRequest"=true})
     */
    public function guestPagelet(Request $request, SalesChannelContext $context): Response
    {
        $pagelet = $this->guestPageLoader->loadPagelet($request, $context);

        return $this->renderStorefront('@Storefront/storefront/page/wishlist/wishlist-pagelet.html.twig', ['searchResult' => $pagelet->getSearchResult()->getResult()]);
    }

    /**
     * @Since("6.3.4.0")
     * @LoginRequired()
     * @Route("/widgets/wishlist", name="widgets.wishlist.pagelet", options={"seo"="false"}, methods={"GET", "POST"}, defaults={"XmlHttpRequest"=true})
     */
    public function ajaxPagination(Request $request, SalesChannelContext $context): Response
    {
        $request->request->set('no-aggregations', true);

        $page = $this->wishlistPageLoader->load($request, $context);

        return $this->renderStorefront('@Storefront/storefront/page/wishlist/index.html.twig', ['page' => $page]);
    }

    /**
     * @Since("6.3.4.0")
     * @Route("/wishlist/list", name="frontend.wishlist.product.list", options={"seo"="false"}, methods={"GET"}, defaults={"XmlHttpRequest"=true})
     */
    public function ajaxList(Request $request, SalesChannelContext $context): Response
    {
        if (!Feature::isActive('FEATURE_NEXT_10549')) {
            throw new NotFoundHttpException();
        }

        try {
            $res = $this->wishlistLoadRoute->load($request, $context, new Criteria());
        } catch (CustomerWishlistNotFoundException $exception) {
            return new JsonResponse([]);
        }

        return new JsonResponse($res->getProductListing()->getIds());
    }

    /**
     * @Since("6.3.4.0")
     * @LoginRequired()
     * @Route("/wishlist/product/delete/{id}", name="frontend.wishlist.product.delete", methods={"POST", "DELETE"}, defaults={"XmlHttpRequest"=true})
     */
    public function remove(string $id, Request $request, SalesChannelContext $context, ?CustomerEntity $customer = null): Response
    {
        if (!$id) {
            throw new MissingRequestParameterException('Parameter id missing');
        }

        try {
            /* @deprecated tag:v6.4.0 - Parameter $customer will be mandatory when using with @LoginRequired() */
            $this->removeWishlistProductRoute->delete($id, $context, $customer);

            $this->addFlash('success', $this->trans('wishlist.itemDeleteSuccess'));
        } catch (\Throwable $exception) {
            $this->addFlash('danger', $this->trans('error.message-default'));
        }

        return $this->createActionResponse($request);
    }

    /**
     * @Since("6.3.4.0")
     * @LoginRequired()
     * @Route("/wishlist/add/{productId}", name="frontend.wishlist.product.add", options={"seo"="false"}, methods={"POST"}, defaults={"XmlHttpRequest"=true})
     */
    public function ajaxAdd(string $productId, SalesChannelContext $context, ?CustomerEntity $customer = null): JsonResponse
    {
        if (!Feature::isActive('FEATURE_NEXT_10549')) {
            throw new NotFoundHttpException();
        }

        /* @deprecated tag:v6.4.0 - Parameter $customer will be mandatory when using with @LoginRequired() */
        $this->addWishlistRoute->add($productId, $context, $customer);

        return new JsonResponse([
            'success' => true,
        ]);
    }

    /**
     * @Since("6.3.4.0")
     * @LoginRequired()
     * @Route("/wishlist/remove/{productId}", name="frontend.wishlist.product.remove", options={"seo"="false"}, methods={"POST"}, defaults={"XmlHttpRequest"=true})
     */
    public function ajaxRemove(string $productId, SalesChannelContext $context, ?CustomerEntity $customer = null): JsonResponse
    {
        if (!Feature::isActive('FEATURE_NEXT_10549')) {
            throw new NotFoundHttpException();
        }

        /* @deprecated tag:v6.4.0 - Parameter $customer will be mandatory when using with @LoginRequired() */
        $this->removeWishlistProductRoute->delete($productId, $context, $customer);

        return new JsonResponse([
            'success' => true,
        ]);
    }

    /**
     * @Since("6.3.4.0")
     * @LoginRequired()
     * @Route("/wishlist/add-after-login/{productId}", name="frontend.wishlist.add.after.login", options={"seo"="false"}, methods={"GET"})
     */
    public function addAfterLogin(string $productId, SalesChannelContext $context, ?CustomerEntity $customer = null): Response
    {
        if (!Feature::isActive('FEATURE_NEXT_10549')) {
            throw new NotFoundHttpException();
        }

        try {
            /* @deprecated tag:v6.4.0 - Parameter $customer will be mandatory when using with @LoginRequired() */
            $this->addWishlistRoute->add($productId, $context, $customer);

            $this->addFlash('success', $this->trans('wishlist.itemAddedSuccess'));
        } catch (DuplicateWishlistProductException $exception) {
            $this->addFlash('warning', $exception->getMessage());
        } catch (\Throwable $exception) {
            $this->addFlash('danger', $this->trans('error.message-default'));
        }

        return $this->redirectToRoute('frontend.home.page');
    }

    /**
     * @Since("6.3.4.0")
     * @LoginRequired()
     * @Route("/wishlist/merge", name="frontend.wishlist.product.merge", options={"seo"="false"}, methods={"POST"}, defaults={"XmlHttpRequest"=true})
     */
    public function ajaxMerge(RequestDataBag $requestDataBag, Request $request, SalesChannelContext $context, ?CustomerEntity $customer = null): Response
    {
        if (!Feature::isActive('FEATURE_NEXT_10549')) {
            throw new NotFoundHttpException();
        }

        try {
            /* @deprecated tag:v6.4.0 - Parameter $customer will be mandatory when using with @LoginRequired() */
            $this->mergeWishlistProductRoute->merge($requestDataBag, $context, $customer);

            return $this->renderStorefront('@Storefront/storefront/utilities/alert.html.twig', [
                'type' => 'info', 'content' => $this->trans('wishlist.wishlistMergeHint'),
            ]);
        } catch (\Throwable $exception) {
            $this->addFlash('danger', $this->trans('error.message-default'));
        }

        return $this->createActionResponse($request);
    }

    /**
     * @Since("6.3.4.0")
     * @LoginRequired()
     * @Route("/wishlist/merge/pagelet", name="frontend.wishlist.product.merge.pagelet", methods={"GET", "POST"}, defaults={"XmlHttpRequest"=true})
     */
    public function ajaxPagelet(Request $request, SalesChannelContext $context): Response
    {
        $request->request->set('no-aggregations', true);

        $page = $this->wishlistPageLoader->load($request, $context);

        return $this->renderStorefront('@Storefront/storefront/page/wishlist/wishlist-pagelet.html.twig', ['page' => $page]);
    }
}
