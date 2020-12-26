Shopware.Service('privileges')
    .addPrivilegeMappingEntry({
        category: 'additional_permissions',
        parent: null,
        key: 'system',
        roles: {
            core_update: {
                privileges: ['system:core:update'],
                dependencies: []
            }
        }
    })
    .addPrivilegeMappingEntry({
        category: 'additional_permissions',
        parent: null,
        key: 'system',
        roles: {
            plugin_maintain: {
                privileges: ['system:plugin:maintain'],
                dependencies: []
            }
        }
    });
