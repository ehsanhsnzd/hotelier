import { execute } from '~/utils/methods/publicScripts'

export const state = () => ({
    book: []
})


export const actions = {
    allItems(ctx, data) {
        return execute('get', '/api/v1/trivago/hotel');
    },
    getItem(ctx, id) {
        return execute('get', '/api/v1/trivago/hotel/'+id);
    },
    bookItem(ctx, data) {
        return execute('post', '/api/v1/trivago/hotel/book',data);
    },
    createItem(ctx, data) {
        return execute('post', `/api/v1/trivago/hotel/`,data);
    },
    editItem(ctx,data) {
        return execute('put', '/api/v1/trivago/hotel/',data);
    },
    deleteItem(ctx, id) {
        return execute('delete', '/api/v1/trivago/hotel/'+id);
    },
}
