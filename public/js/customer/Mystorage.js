window.indexedDB =
  window.indexedDB ||
  window.mozIndexedDB ||
  window.webkitIndexedDB ||
  window.msIndexedDB;

window.IDBTransaction =
  window.IDBTransaction ||
  window.webkitIDBTransaction ||
  window.msIDBTransaction;
window.IDBKeyRange =
  window.IDBKeyRange || window.webkitIDBKeyRange || window.msIDBKeyRange;
if (!window.indexedDB) {
  window.alert("Your browser doesn't support a stable version of IndexedDB.");
}
var db;
function initDB(dbName, dbVersion, stores) {
  return new Promise((resolve, reject) => {
    var db;
    var request = window.indexedDB.open(dbName, dbVersion);
    request.onerror = function (event) {
      reject(event.target.error);
    };
    request.onsuccess = function (event) {
      db = request.result;
      db.onversionchange = function () {
        db.close();
        reject("Database is outdated,please reload the page");
      };
      resolve(db);
    };
    request.onupgradeneeded = function (event) {
      db = event.target.result;
      //   {keyPath: "id",}
      stores.forEach((o) => {
        if (!db.objectStoreNames.contains(`${o.name}`)) {
          let store = db.createObjectStore(o.name, o.option);
          if (o.indeces) {
            let i = o.indeces;
            let index = store.createIndex(`${i.name}`, `${i.track}`);
          }
        }
      });
      resolve(db);
    };
  });
}
function deleteDB(db) {
  if (window.indexedDB) {
    window.indexedDB.deleteDatabase(db);
  }
}
function deleteStore(dbConn, storeName) {
  return new Promise((resolve, reject) => {
    if (dbConn) {
      dbConn.deleteObjectStore(storeName);
      dbConn.oncomplete = (e) => resolve(e.target.result);
      dbConn.onabort = (e) => reject(e.target.error);
      dbConn.error = (e) => reject(e.target.error);
    }
    reject(`${storeName} not removed try again`);
  });
}
// insert
function upsert(dbConn, storeName, data) {
  return new Promise((resolve, reject) => {
    if (dbConn && data) {
      let transaction = dbConn.transaction(
        [storeName],
        IDBTransaction.READ_WRITE
      );
      transaction.onabort = (te) => reject(te.target.error);
      transaction.onerror = (te) => reject(te.target.error);
      let request = transaction.objectStore(storeName).put(data);
      request.onerror = (e) => reject(e.target.error);
      request.onsuccess = (e) => resolve(e.target.result);
    }
    reject("Database connection || data not provided");
  });
}
// getByKey
function getByKey(dbConn, storeName, key) {
  return new Promise((resolve, reject) => {
    if (dbConn && key) {
      let request = dbConn.transaction([storeName]).objectStore().get(key);
      request.onerror = (e) => reject(e.target.error);
      request.onsuccess = (e) => resolve(e.target.result);
    }
    reject("dbconnection or key not given");
  });
}
//get all
function getAll(dbConn, storeName) {
  return new Promise((resolve, reject) => {
    if (dbConn) {
      let request = dbConn
        .transaction(storeName)
        .objectStore(storeName)
        .openCursor(null, IDBCursor.NEXT);
      let results = [];
      request.onsuccess = (e) => {
        let cursor = e.target.result;
        if (cursor) {
          results.push({ [cursor.key]: cursor.value });
          cursor.continue();
        } else {
          resolve(results);
        }
      };
      request.onerror = (e) => reject(e.target.error);
    }
    reject("DB connection not provided");
  });
}
// delete
function deleteByKey(dbConn, storeName, key) {
  return new Promise((resolve, reject) => {
    if (dbConn && key) {
      let request = this.db
        .transaction([storeName], IDBTransaction.READ_WRITE)
        .objectStore(storeName)
        .delete(key);
      request.onerror = (e) => reject(e.target.error);
      request.onsuccess = (e) => resolve(e.target.result);
    }
    reject("database connection or key not provided");
  });
}
// clear store
function clear(dbConn, storeName) {
  return new Promise((resolve, reject) => {
    if (dbConn) {
      let request = this.db
        .transaction([storeName], IDBTransaction.READ_WRITE)
        .objectStore(storeName)
        .clear();
      request.onerror = (e) => reject(e.target.error);
      request.onsuccess = (e) => resolve(e.target.result);
    }
    reject("database connection not established");
  });
}
// count
function count(dbConn, storeName) {
  if (dbConn) {
    let request = dbConn
      .transaction([storeName])
      .objectStore(storeName)
      .count();
    request.onerror = (e) => reject(e.target.error);
    request.onsuccess = (e) => resolve(e.target.result);
  }
  reject("database connection not established");
}
//  search by index
function searchByIndex(dbConn, storeName, indexName, limit = 10) {
  return new Promise((resolve, reject) => {
    if (dbConn) {
      let request = dbConn
        .transaction(storeName)
        .objectStore(storeName)
        .index(`${indexName}`)
        .getAll(limit);
      request.onsuccess = (e) => {
        let cursor = e.target.result;
        if (cursor !== undefined) {
          resolve(cursor);
        } else {
          reject(`No Such ${storeName}`);
        }
      };
      request.onerror = (e) => reject(e.target.error);
    }
    reject("DB connection not provided");
  });
}
// usage
/*
const stores = [
  {
    name: "users",
    option: { keyPath: "id", autoIncrement: true },
    indeces: { name: "username_idx", track: "username" },
  },
    {
    name: "userLogs",
    option: { keyPath: "id", autoIncrement: true },
  },
];
initDB("mstoma_usersdb", 1, stores)
  .then((result) => { 
    db = result;
  })
  .catch((err) => {
    alert(err);
  });
  */
