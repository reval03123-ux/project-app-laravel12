<!-- Modal -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createProductModalLabel">Tambah Produk</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3 row">
              <label for="name" class="col-sm-3 col-form-label">Product Name</label>
              <div class="col-sm-9">
                  <input type="text" class="form-control" id="name" name="name" required autofocus>
              </div>
          </div>
          <div class="mb-3 row">
              <label for="price" class="col-sm-3 col-form-label">Price</label>
              <div class="col-sm-9">
                  <input type="number" class="form-control" id="price" name="price" required>
              </div>
          </div>
          <div class="mb-3 row">
              <label for="stock" class="col-sm-3 col-form-label">Stock</label>
              <div class="col-sm-9">
                  <input type="number" class="form-control" id="stock" name="stock" required>
              </div>
          </div>
          <div class="mb-3 row">
              <label for="description" class="col-sm-3 col-form-label">Description</label>
              <div class="col-sm-9">
                  <textarea class="form-control" id="description" name="description"></textarea>
              </div>
          </div>
          <div class="mb-3 row">
              <label for="image" class="col-sm-3 col-form-label">Image</label>
              <div class="col-sm-9">
                  <input type="file" class="form-control" id="image" name="image">
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
