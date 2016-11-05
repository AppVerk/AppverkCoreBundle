<?php

namespace Cube\CoreBundle\Controller;

use Doctrine\ORM\Query;
use Knp\Component\Pager\Pagination\SlidingPagination;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
    protected function paginatedData(Request $request, Query $query)
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pagination */
        $pagination = $paginator->paginate($query, $page, $limit);
        $paginationData = $pagination->getPaginationData();

        $data = [
            'current_page' => $pagination->getCurrentPageNumber(),
            'items_per_page' => $pagination->getItemNumberPerPage(),
            'total_items' => $pagination->getTotalItemCount(),
            'items' => $pagination->getItems(),
            'pagination' => $pagination,
            'last_page' => $paginationData['endPage']
        ];

        return $data;
    }
}
