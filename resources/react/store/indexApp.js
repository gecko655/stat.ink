import blogSaga from '../saga/blog';
import createSagaMiddleware, { SagaMiddleware } from 'redux-saga';
import reducer from '../reducers/indexApp';
import scheduleSaga from '../saga/schedule';
import { all } from 'redux-saga/effects';
import { applyMiddleware, createStore } from 'redux';

function* rootSaga() {
  yield all([
    ...blogSaga,
    ...scheduleSaga,
  ]);
}

const sagaMiddleware = createSagaMiddleware();

const configureStore = () => {
  const store = createStore(reducer, applyMiddleware(sagaMiddleware));
  sagaMiddleware.run(rootSaga);
  return store;
};

const store = configureStore();

if (process.env.NODE_ENV === 'development') {
  store.subscribe(() => {
    const state = store.getState();
    console.log(state);
  });
}

export default store;
