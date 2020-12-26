Shopware.Service('privileges').addPrivilegeMappingEntry({
    category: 'permissions',
    parent: 'settings',
    key: 'delivery_times',
    roles: {
        viewer: {
            privileges: [
                'delivery_time:read'
            ],
            dependencies: []
        },
        editor: {
            privileges: [
                'delivery_time:update'
            ],
            dependencies: [
                'delivery_times.viewer'
            ]
        },
        creator: {
            privileges: [
                'delivery_time:create'
            ],
            dependencies: [
                'delivery_times.viewer',
                'delivery_times.editor'
            ]
        },
        deleter: {
            privileges: [
                'delivery_time:delete'
            ],
            dependencies: [
                'delivery_times.viewer'
            ]
        }
    }
});
