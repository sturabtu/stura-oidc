<?php

namespace StuRaBtu\Oidc\Enums;

enum Role: string
{
    // Wiki
    case WIKI_ACCESS = 'stura-wiki::access';
    case WIKI_ADMIN = 'stura-wiki::admin';
    case WIKI_GROUP_ADMIN = 'stura-wiki::group-admin';
    case WIKI_GROUP_STUPA = 'stura-wiki::group-stupa';
    case WIKI_GROUP_STURA = 'stura-wiki::group-stura';
    case WIKI_GROUP_PRAESIDIUM = 'stura-wiki::group-praesidium';
    case WIKI_GROUP_WAKO = 'stura-wiki::group-wako';

    // Website
    case WEBSITE_ACCESS = 'stura-website::access';
    case WEBSITE_ADMIN = 'stura-website::admin';
    case WEBSITE_RESOURCE_ELECTIONS = 'stura-website::resource-elections';
    case WEBSITE_RESOURCE_PAGES = 'stura-website::resource-pages';
    case WEBSITE_RESOURCE_REDIRECTS = 'stura-website::resource-redirects';
    case WEBSITE_RESOURCE_NEWS = 'stura-website::resource-news';

    // Storage
    case STORAGE_ACCESS = 'stura-storage::access';
    case STORAGE_ADMIN = 'stura-storage::admin';

    // Events
    case EVENTS_ACCESS = 'stura-events::access';
    case EVENTS_ADMIN = 'stura-events::admin';
    case EVENTS_MANAGE_OWN_GROUPS = 'stura-events::manage-own-groups';

    // Forms
    case FORMS_ACCESS = 'stura-forms::access';
    case FORMS_ADMIN = 'stura-forms::admin';
    case FORMS_RESOURCE_SEMTIX = 'stura-forms::resource-semtix';
    case FORMS_RESOURCE_SEMTIX_CHIPCARD = 'stura-forms::resource-semtix-chipcard';
    case FORMS_RESOURCE_WELCOME_BABY = 'stura-forms::resource-welcome-baby';
    case FORMS_RESOURCE_STUDENT_BODY = 'stura-forms::resource-student-body';
}
