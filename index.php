<!doctype html>
<html lang="en" ng-app='pilas' ng-controller='pilasController'>

<head>
  <title>Pila$</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>


  <nav class="navbar navbar-expand navbar-light bg-light">
    <div class="nav navbar-nav mr-auto">
      <a class="nav-item nav-link" href="/">
        <img src="./images/logo.png" style="max-height: 30px;" class="img-fluid">
      </a>
      <a href class="nav-item nav-link" data-toggle="modal" data-target="#modal-categorias">Categeorias</a>
      <a href class="nav-item nav-link" data-toggle="modal" data-target="#modal-lancamento">Novo Lançamento</a>
    </div>
    <form class="form-inline my-2 my-lg-0">
      <input ng-model='query' class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Pesquisar</button>
    </form>
  </nav>

  <div class="container-fluid">
    <div class="container">
      <div class="jumbotron">
        <h1 class="display-3">PILA$</h1>
        <p class="lead">Nesta aplicação web você poderá geranciar todos os seus pilas!</p>
        <hr class="my-2">
        <p>Resgistre aqui todos os pilas que você ganha e todos os pilas que você gasta, separe em quantas categorias
          quiser</p>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="container">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th></th>
              <th>Categoria</th>
              <th>Data Hora</th>
              <th>Descrição</th>
              <th>Pilas</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat='item in launch | filter:query'>
              <td>
                {{ item.type ? '+' : '-' }}
              </td>
              <td>
                {{ item.id_category }}
              </td>
              <td>
                {{ item.created_at | date }}
              </td>
              <td>
                {{ item.description }}
              </td>
              <td>
                {{ item.value | currency }}
              </td>
              <td>
                <button ng-click='loadLaunch(item)' class="btn btn-primary" data-toggle="modal" data-target="#modal-alterar">Alterar</button>
              </td>
              <td>
                <!-- <button class="btn btn-danger" data-toggle="modal" data-target="#modal-excluir">Excluir</button> -->
                <button ng-click='deleteLaunch(item._id)' class="btn btn-danger">Excluir</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal categorias -->
  <div class="modal fade" id="modal-categorias" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Categorias</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="pl-3" >
            <div class="form-group row">
              <label for="inputName" class="col-sm-1-12 col-form-label"></label>
              <div class="col-sm-1-12">
                <input ng-model='category' type="text" class="form-control" name="inputName" id="inputName"
                  placeholder="Digite o nome da categoria">
              </div>
              <button ng-click='saveCategory()' class="ml-2 btn btn-primary">Adicionar</button>
            </div>
          </form>
          <div class="list-group">
            <div ng-repeat='category in categories' class="list-group-item">
              {{ category.name }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal lancamento -->
  <div class="modal fade" id="modal-lancamento" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Novo lançamento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="">Categoria</label>
              <select ng-model='id_category' class="form-control" name="">
                <option ng-repeat='category in categories track by $index' ng-value="category._id">{{ category.name }}</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Tipo</label>
              <select ng-model='type' class="form-control" name="" id="">
                <option value="0">Gastei pilas (-)</option>
                <option value="1">Ganhei pilas (+)</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Descrição</label>
              <input ng-model='description' type="text" class="form-control" name="" id="" aria-describedby="helpId"
                placeholder="Digite a descrição do lançamento">
            </div>
            <div class="form-group">
              <label for="">Pilas</label>
              <input ng-model='value' type="text" class="form-control" name="" id="" aria-describedby="helpId"
                placeholder="Quantos pilas">
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <button ng-click='saveLaunch()' type="button" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal alterar -->
  <div class="modal fade" id="modal-alterar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Alterar lançamento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form>
            <div class="form-group">
              <label for="">Descrição</label>
              <input ng-model='update.description' type="text" class="form-control" name="" id="" aria-describedby="helpId"
                placeholder="Digite a descrição do lançamento">
            </div>
            <div class="form-group">
              <label for="">Pilas</label>
              <input ng-model='update.value' type="text" class="form-control" name="" id="" aria-describedby="helpId"
                placeholder="Quantos pilas">
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <button ng-click='updateLaunch()' type="button" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
  <script src="app.js"></script>

</body>

</html>