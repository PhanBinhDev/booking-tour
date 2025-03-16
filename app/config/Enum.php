<?php

namespace App\Config;

class Enum
{
    // User status
    const USER_STATUS = [
        'ACTIVE' => 'active',
        'INACTIVE' => 'inactive',
        'BANNED' => 'banned',
    ];

    const IMAGE_CATEGORY = [
        'GENERAL' => 'general',
        'TOURS' => 'tours',
        'LOCATIONS' => 'locations',
        'BANNER' => 'banner',
    ];

    // User gender
    const USER_GENDER = [
        'MALE' => 'male',
        'FEMALE' => 'female',
        'OTHER' => 'other',
    ];

    // Tour category status
    const TOUR_CATEGORY_STATUS = [
        'ACTIVE' => 'active',
        'INACTIVE' => 'inactive',
    ];

    // Location status
    const LOCATION_STATUS = [
        'ACTIVE' => 'active',
        'INACTIVE' => 'inactive',
    ];

    // Tour status
    const TOUR_STATUS = [
        'ACTIVE' => 'active',
        'INACTIVE' => 'inactive',
        'DRAFT' => 'draft',
    ];

    // Tour date status
    const TOUR_DATE_STATUS = [
        'AVAILABLE' => 'available',
        'FULL' => 'full',
        'CANCELLED' => 'cancelled',
    ];

    // Booking status
    const BOOKING_STATUS = [
        'PENDING' => 'pending',
        'CONFIRMED' => 'confirmed',
        'PAID' => 'paid',
        'CANCELLED' => 'cancelled',
        'COMPLETED' => 'completed',
    ];

    // Payment status
    const PAYMENT_STATUS = [
        'PENDING' => 'pending',
        'PAID' => 'paid',
        'REFUNDED' => 'refunded',
        'FAILED' => 'failed',
    ];

    // Review status
    const REVIEW_STATUS = [
        'PENDING' => 'pending',
        'APPROVED' => 'approved',
        'REJECTED' => 'rejected',
    ];

    // Comment status
    const COMMENT_STATUS = [
        'PENDING' => 'pending',
        'APPROVED' => 'approved',
        'REJECTED' => 'rejected',
    ];

    // News status
    const NEWS_STATUS = [
        'PUBLISHED' => 'published',
        'DRAFT' => 'draft',
        'ARCHIVED' => 'archived',
    ];

    // Banner status
    const BANNER_STATUS = [
        'ACTIVE' => 'active',
        'INACTIVE' => 'inactive',
    ];

    // Contact status
    const CONTACT_STATUS = [
        'NEW' => 'new',
        'READ' => 'read',
        'REPLIED' => 'replied',
        'ARCHIVED' => 'archived',
    ];

    // Refund status
    const REFUND_STATUS = [
        'PENDING' => 'pending',
        'PROCESSING' => 'processing',
        'COMPLETED' => 'completed',
        'REJECTED' => 'rejected',
    ];

    // Invoice status
    const INVOICE_STATUS = [
        'DRAFT' => 'draft',
        'ISSUED' => 'issued',
        'PAID' => 'paid',
        'CANCELLED' => 'cancelled',
        'REFUNDED' => 'refunded',
    ];
}
?>