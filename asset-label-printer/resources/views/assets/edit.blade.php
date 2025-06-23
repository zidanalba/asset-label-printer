                        <div class="col-md-4 mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $asset->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="infrastructure_id" class="form-label">Location (Infrastructure)</label>
                            <select class="form-select @error('infrastructure_id') is-invalid @enderror" id="infrastructure_id" name="infrastructure_id">
                                <option value="">Select Location</option>
                                @foreach($infrastructures as $infra)
                                    <option value="{{ $infra->id }}" {{ old('infrastructure_id', $asset->infrastructure_id) == $infra->id ? 'selected' : '' }}>{{ $infra->name }}</option>
                                @endforeach
                            </select>
                            @error('infrastructure_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> 