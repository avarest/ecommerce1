/// <reference types="Cypress" />

import ProductPageObject from '../../../support/pages/module/sw-product.page-object';

describe('Promotion: Test promotion with preconditional rules', () => {
    beforeEach(() => {
        cy.setToInitialState()
            .then(() => {
                cy.loginViaApi();
            })
            .then(() => {
                return cy.createDefaultFixture('promotion');
            })
            .then(() => {
                return cy.createProductFixture();
            })
            .then(() => {
                return cy.createCustomerFixture();
            })
            .then(() => {
                cy.openInitialPage(`${Cypress.env('admin')}#/sw/promotion/index`);
            });
    });

    it('@marketing: use general precondition rule', () => {
        const page = new ProductPageObject();

        // Request we want to wait for later
        cy.server();
        cy.route({
            url: `${Cypress.env('apiPath')}/promotion`,
            method: 'post'
        }).as('saveData');
        cy.route({
            url: `${Cypress.env('apiPath')}/search/promotion/**/discounts`,
            method: 'post'
        }).as('saveDiscount');

        // Active code in promotion
        cy.contains(`${page.elements.dataGridRow}--0 a`, 'Thunder Tuesday').click();
        cy.get('input[name="sw-field--promotion-active"]').should('be.visible');
        cy.get('input[name="sw-field--promotion-active"]').click();
        cy.get('.sw-promotion-sales-channel-select').typeMultiSelectAndCheck('Storefront');
        cy.get('.sw-promotion-sales-channel-select .sw-select-selection-list__input')
            .type('{esc}');
        cy.get('input[name="sw-field--promotion-useCodes"]').click();
        cy.get('#sw-field--promotion-code').should('be.enabled');
        cy.get('#sw-field--promotion-code').type('funicular');

        // Add promotion rule
        cy.get('a[title="Preconditions"]').click();
        cy.contains('.sw-card__title', 'Target group').should('be.visible');
        cy.get('input[name="sw-field--promotion-customerRestriction"]').click();
        cy.get('.sw-promotion-persona-form-customers').should('be.visible');
        cy.get('.sw-promotion-persona-form-customers__customer-search').click();
        cy.get('.sw-select-result-list__item-list').should('be.visible');
        cy.contains('Pep Eroni').click();
        cy.get('.sw-data-grid__cell--fullName').contains('Pep Eroni');

        // Add discount
        cy.get('a[title="Discounts"]').click();
        cy.get(page.elements.loader).should('not.exist');
        cy.get('.sw-button--ghost').should('be.visible');
        cy.contains('.sw-button--ghost', 'Add discount').click();
        cy.get(page.elements.loader).should('not.exist');
        cy.wait('@filteredResultCall').then((xhr) => {
            expect(xhr).to.have.property('status', 200);
        });

        cy.get('.sw-promotion-discount-component').should('be.visible');
        cy.get('.sw-promotion-discount-component__discount-value').should('be.visible');
        cy.get('.sw-promotion-discount-component__discount-value input')
            .clear()
            .type('54');

        // Save final promotion
        cy.get('.sw-promotion-detail__save-action').click();
        cy.wait('@saveDiscount').then((xhr) => {
            expect(xhr).to.have.property('status', 200);
        });

        // Verify Promotion in Storefront
        cy.visit('/');
        cy.get('.product-box').should('be.visible');
        cy.get('.btn-buy').click();
        cy.get('.offcanvas.is-open').should('be.visible');
        cy.get('#addPromotionOffcanvasCartInput').type('funicular');
        cy.get('#addPromotionOffcanvasCart').click();
        cy.get('.alert-success .icon-checkmark-circle').should('be.visible');
        cy.contains('Promotion code valid - however, not all conditions were met and the discount was not applied.');
        cy.get('.begin-checkout-btn').click();

        // Log in as customer eligible for the code
        cy.get('.login-collapse-toggle').should('be.visible');
        cy.get('.login-collapse-toggle').click();
        cy.get('.login-form').should('be.visible');
        cy.get('#loginMail').typeAndCheckStorefront('test@example.com');
        cy.get('#loginPassword').typeAndCheckStorefront('shopware');
        cy.get('.login-submit [type="submit"]').click();

        cy.get('.cart-item-promotion').scrollIntoView();
        cy.get('.cart-item-promotion .cart-item-label').contains('Thunder Tuesday');
    });
});
